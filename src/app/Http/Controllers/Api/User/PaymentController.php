<?php

namespace App\Http\Controllers\Api\User;

use App\Concerns\CustomValidation;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\GatewayCode;
use App\Enums\Payment\NotificationType;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentProcessRequest;
use App\Http\Resources\DepositResource;
use App\Http\Resources\PaymentGatewayResource;
use App\Models\PaymentGateway;
use App\Notifications\DepositNotification;
use App\Services\Payment\DepositService;
use App\Services\Payment\PaymentService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Throwable;

class PaymentController extends Controller
{
    use CustomValidation;
    public function __construct(
        protected PaymentService $paymentService,
        protected DepositService $depositService,
    ){

    }

    public function index(): JsonResponse
    {
        $deposits = $this->depositService->getUserDepositByPaginated((int)Auth::id(), ['gateway'], Status::INITIATED->value);

        return ApiJsonResponse::success("Payment information fetched successfully.", [
            'payment_gateways' => PaymentGatewayResource::collection($this->paymentService->fetchActivePaymentGateways()),
            'deposits' => DepositResource::collection($deposits),
            'deposits_meta' => paginateMeta($deposits),
        ]);
    }


    /**
     * @param PaymentProcessRequest $request
     * @return JsonResponse
     */
    public function process(PaymentProcessRequest $request): JsonResponse
    {
        try {
            $gateway = $this->paymentService->findByCode($request->input('code'));
            if ($request->input('amount') < $gateway->minimum || $request->input('amount') > $gateway->maximum) {
                return ApiJsonResponse::error('The investment amount should be between ' . getCurrencySymbol().shortAmount($gateway->minimum) . ' and ' . getCurrencySymbol().shortAmount($gateway->maximum));
            }

            $payment = $this->paymentService->makePayment($gateway, $request, (float) $request->input('amount'));

            return ApiJsonResponse::success("Payment processed.",[
                'url' => $payment,
            ]);

        }catch (\Exception $exception){
            return ApiJsonResponse::error($exception->getMessage());
        }
    }

    /**
     * @param PaymentProcessRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function traditionalPaymentApi(PaymentProcessRequest $request): JsonResponse
    {
        $gateway = $this->paymentService->findByCode($request->input('code'));

        if(!$gateway){
            return ApiJsonResponse::error('Invalid Payment Gateway');
        }

        $this->validate($request, $this->parameterValidation((array)$gateway->parameter));
        $deposit = $this->depositService->save(
            $this->depositService->prepParams($gateway,$request->input('amount'), $request)
        );

        $deposit->meta = $this->paymentService->parameterStoreData(((array)$gateway->parameter));
        $deposit->save();

        $this->paymentService->successPayment($deposit->trx);
        $deposit->notify(new DepositNotification(NotificationType::REQUESTED));

        return ApiJsonResponse::success('Payment processed successfully');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ApiErrorException
     * @throws Throwable
     */
    public function success(Request $request): JsonResponse
    {
        $request->validate([
            'gateway_code' => ['required', Rule::in(GatewayCode::values())],
        ]);

        $trxId = null;
        if($request->input('gateway_code') == GatewayCode::STRIPE->value){
            $paymentGateway = $this->paymentService->findByCode(GatewayCode::STRIPE->value);
            Stripe::setApiKey(Arr::get($paymentGateway->parameter,'secret_key'));

            $paymentIntent = Session::retrieve($request->input('payment_intent'));
            $trxId = $paymentIntent->metadata['transaction_id'] ?? '';
        }

        if($request->input('gateway_code') == GatewayCode::PAYPAL->value){
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $trxId = $request->input('trx');
            }
        }

        if($request->input('gateway_code') == GatewayCode::COINBASE_COMMERCE->value){
            $trxId = $request->input('trx');
        }

        if (is_null($trxId)) {
            return ApiJsonResponse::error('Invalid payment gateway code');
        }

        $payment = $this->paymentService->successPayment($trxId);
        if (!$payment) {
            return ApiJsonResponse::error('Something went wrong with the payment');
        }

        return ApiJsonResponse::success('Payment processed successfully.');
    }
}
