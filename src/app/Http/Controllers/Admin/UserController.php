<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Binary;
use App\Models\Deposit;
use Illuminate\View\View;
use App\Models\Commission;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;
use App\Enums\CommissionType;
use App\Services\UserService;
use App\Enums\Trade\TradeType;
use App\Enums\Transaction\Type;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\Transaction\WalletType;
use Illuminate\Http\RedirectResponse;
use App\Services\Payment\DepositService;
use App\Services\Payment\WithdrawService;
use App\Services\Trade\ActivityLogService;
use App\Services\Payment\TransactionService;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\MatrixInvestmentService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected InvestmentService $investmentService,
        protected ActivityLogService $activityLogService,
        protected MatrixInvestmentService $matrixInvestmentService,
        protected DepositService $depositService,
        protected WithdrawService $withdrawService,
        protected CommissionService $commissionService,
        protected TransactionService $transactionService,
    ) {}


    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $setTitle = __('admin.user.page_title.index');
        $users = $this->userService->getUsersByPaginate(with: ['wallet']);

        return view('admin.user.index', compact('setTitle', 'users'));
    }

    /**
     * @return View
     */
    public function identity(): View
    {
        $setTitle = 'KYC Identity Logs';
        $users = $this->userService->getUsersIdentityByPaginate();
        return view('admin.user.identity', compact('setTitle', 'users'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('admin.user.page_title.details');
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        [$months, $depositMonthAmount, $withdrawMonthAmount] = $this->depositService->monthlyReport(userId: $user->id);
        $investment = $this->investmentService->getInvestmentReport(userId: $user->id);
        $trade = $this->activityLogService->getTradeReport(userId: $user->id);

        $statistics = [
            'deposit' => Deposit::where('status', \App\Enums\Payment\Deposit\Status::SUCCESS->value)->where('user_id', $user->id)->sum('amount'),
            'withdraw' => WithdrawLog::where('status', \App\Enums\Payment\Deposit\Status::SUCCESS->value)->where('user_id', $user->id)->sum('amount'),
            'level_commission' => Commission::where('type', CommissionType::LEVEL->value)->where('user_id', $user->id)->sum('amount'),
            'referral_commission' => Commission::where('type', CommissionType::REFERRAL->value)->where('user_id', $user->id)->sum('amount'),
        ];

        return view('admin.user.details', compact(
            'setTitle',
            'user',
            'investment',
            'trade',
            'statistics',
            'depositMonthAmount',
            'withdrawMonthAmount',
            'months'
        ));
    }


    /**
     * @param UserRequest $request
     * @param string|int $id
     * @return mixed
     */
    public function update(UserRequest $request, string|int $id): mixed
    {
        $user = User::where('id', $id)->firstOrFail();

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'meta' => [
                'address' => [
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip' => $request->input('zip'),
                ]
            ],
            'kyc_status' => $request->input('kyc_status'),
            'status' => $request->input('status'),
        ]);

        return back()->with('notify', [['success', __('User has been updated')]]);
    }


    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function identityUpdate(Request $request): RedirectResponse
    {
        $user = User::where('id', $request->input('id'))->firstOrFail();
        $user->kyc_status = $request->input('kyc_status');
        $user->save();

        return back()->with('notify', [['success', __('User KYC Identity has been updated')]]);
    }


    /**
     * @param int|string $userId
     * @return View
     */
    public function transactions(int|string $userId): View
    {
        $user = $this->userService->findById($userId);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.report.page_title.transaction_user', ['full_name' => $user->fullname]);
        $transactions = $this->transactionService->getTransactions(['user'], userId: $user->id);

        return view('admin.statistic.transaction', compact(
            'setTitle',
            'transactions',
        ));
    }

    /**
     * @param int|string $id
     * @return View
     */
    public function statistic(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $investment = $this->investmentService->getInvestmentReport(userId: $user->id);
        $trade = $this->activityLogService->getTradeReport(userId: $user->id);
        [$months, $invest, $profit] = $this->investmentService->monthlyReport(userId: $user->id);
        [$days, $amount] = $this->activityLogService->dayReport(userId: $user->id);

        return view('admin.user.statistic', compact(
            'user',
            'investment',
            'trade',
            'months',
            'invest',
            'profit',
            'days',
            'amount',
        ));
    }

    /**
     * @param int|string $id
     * @return View
     */
    public function referralTree(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.user.content.referral_user', ['full_name' => $user->full_name]);
        return view('admin.user.referral', compact(
            'setTitle',
            'user',
        ));
    }

    /**
     * @param int|string $id
     * @return RedirectResponse
     */
    public function loginAsUser(int|string $id): RedirectResponse
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        Auth::login($user);
        return redirect()->route('user.dashboard');
    }

    /**
     * @param int|string $id
     * @return View
     */
    public function investment(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.binary.page_title.investment_plan', ['plan_name' => ucfirst($user->fullname)]);
        $investmentLogs = $this->investmentService->getInvestmentLogsByPaginate(userId: $user->id);

        return view('admin.binary.investment', compact(
            'setTitle',
            'investmentLogs',
        ));
    }


    /**
     * @param int|string $id
     * @return View
     */
    public function matrix(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.matrix.page_title.user_matrix', ['full_name' => ucfirst($user->fullname)]);
        $matrixLog = $this->matrixInvestmentService->findByUserId($user->id);

        return view('admin.user.matrix-enrolled', compact(
            'setTitle',
            'matrixLog',
        ));
    }


    /**
     * @param int|string $id
     * @return View
     */
    public function deposit(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.deposit.page_title.user', ['full_name' => $user->full_name]);
        $deposits = $this->depositService->getUserDepositByPaginated($user->id);

        return view('admin.deposit.index', compact(
            'deposits',
            'setTitle'
        ));
    }

    public function withdraw(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.withdraw.page_title.user', ['full_name' => $user->fullname]);
        $withdrawLogs = $this->withdrawService->fetchWithdrawLogs(userId: $user->id, with: ['user']);

        return view('admin.withdraw.index', compact(
            'setTitle',
            'withdrawLogs'
        ));
    }


    /**
     * @param int|string $id
     * @return View
     */
    public function trade(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.trade_activity.page_title.trade_crypto', ['crypto' => ucfirst($user->fullname)]);
        $trades = $this->activityLogService->getByPaginate(tradeType: TradeType::TRADE, userId: $user->id);

        return view('admin.trade.index', compact('setTitle', 'trades'));
    }


    /**
     * @param int|string $id
     * @return View
     */
    public function level(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.matrix.page_title.user_level', ['full_name' => $user->full_name]);
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::LEVEL, ['user', 'fromUser'], $user->id);

        return view('admin.matrix.commissions', compact(
            'setTitle',
            'commissions'
        ));
    }


    /**
     * @param int|string $id
     * @return View
     */
    public function referral(int|string $id): View
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        $setTitle = __('admin.matrix.page_title.user_referral', ['full_name' => $user->full_name]);
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::REFERRAL, ['user', 'fromUser'], $user->id);

        return view('admin.matrix.commissions', compact(
            'setTitle',
            'commissions'
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveAddSubtractBalance(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'id' => ['required', Rule::exists('users', 'id')],
            'type' => ['required', Rule::in(Type::values())],
            'wallet_type' => ['required', Rule::in(WalletType::values())],
        ]);

        $notify = $this->userService->addSubtractBalance($request);
        return back()->with('notify', [['success', $notify]]);
    }

    public function binaries(Request $request)
    {
        $query = Binary::latest();

        if ($request->has('email')) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $query->where('user_id', $user->id);
            } else {
                // Return an empty paginated result if no user found
                $emptyPagination = new \Illuminate\Pagination\LengthAwarePaginator([], 0, getPaginate());
                return view('admin.user.binary')->with([
                    'setTitle' => 'Binaries',
                    'tradeLogs' => $emptyPagination
                ]);
            }
        }

        $data = [
            'setTitle' => 'Binaries',
            'tradeLogs' => $query->paginate(getPaginate())
        ];

        return view('admin.user.binary')->with($data);
    }

    public function editBinary(Request $request, $id = 0)
    {
        $request->validate([
            'stop_loss' => ['required', 'numeric'],
            'take_profit' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'open_amount' => ['required', 'numeric'],
        ]);

        if ($id) {

            try {
                DB::beginTransaction();
                $trade = Binary::where('id', $id)->first();

                $trade->stop_loss = $request->stop_loss;
                $trade->take_profit = $request->take_profit;
                $trade->amount = $request->amount;
                $trade->open_amount = $request->open_amount;


                $trade->save();

                DB::commit();

                $notify[] = ['success', 'Edit successfull'];

                return back()->withNotify($notify);
            } catch (\Exception $e) {
                DB::rollBack();
                $notify[] = ['error', $e->getMessage()];
                return back()->withNotify($notify);
            }
        }
    }
}
