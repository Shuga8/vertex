<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Services\Payment\Gateway\BlockChainGateway;
use App\Services\Payment\Gateway\CoinbaseCommerce;
use App\Services\Payment\Gateway\CoinGateGateway;
use App\Services\Payment\Gateway\PaypalGateway;
use App\Services\Payment\Gateway\StripeGateway;
use App\Services\Payment\Gateway\TraditionalGateway;

class PaymentGatewayFactory
{
    public static function create(string $gatewayName): PaymentGatewayInterface {
        return match ($gatewayName) {
            GatewayCode::STRIPE->value => new StripeGateway(),
            GatewayCode::PAYPAL->value => new PaypalGateway(),
            GatewayCode::COINBASE_COMMERCE->value => new CoinbaseCommerce(),
            GatewayCode::BLOCK_CHAIN->value => new BlockChainGateway(),
            GatewayCode::COIN_GATE->value => new CoinGateGateway(),
            default => new TraditionalGateway(),
        };
    }

}
