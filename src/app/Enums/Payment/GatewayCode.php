<?php

namespace App\Enums\Payment;

use App\Enums\EnumTrait;

enum GatewayCode: string
{
    use EnumTrait;

    case COINBASE_COMMERCE = 'commerce-12';
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';
    case BLOCK_CHAIN = 'block-chain';
    case COIN_GATE = 'coin-gate';
}
