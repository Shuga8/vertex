<?php

namespace Database\Seeders;

use App\Enums\Payment\GatewayCode;
use App\Enums\Payment\GatewayName;
use App\Enums\Payment\GatewayStatus;
use App\Enums\Payment\GatewayType;
use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::COINBASE_COMMERCE->value),
                "code" => GatewayCode::COINBASE_COMMERCE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "coinbase-commerce.png",
                "parameter" => [
                    "api_key" => "d714c897-0a5c-4150-9253-e37c051a2151",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "0.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::STRIPE->value),
                "code" => GatewayCode::STRIPE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "stripe.png",
                "parameter" => [
                    "secret_key" => "sk_test_51KiXEgK5OxdbbQz6HS933RmEqJV9zN0kqZlDJUjKWg93tM7I3CUJt88fVB4QFlU9FCV2Lr62H6JhuIWc3eUAS7Ky00yeOmml2x",
                    "publishable_key" => "pk_test_51KiXEgK5OxdbbQz688TP1NcuhdtZ6NoI2quvXAMXXtJtBkxTFuZOlYYBhaHG5DkaIPhPJB5FjRjKVVAqi7KhWkXT004r2aGuVq",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::PAYPAL->value),
                "code" => GatewayCode::PAYPAL->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "paypal.png",
                "parameter" => [
                    "environment" => "sandbox",
                    "client_id" => "AXhR_eQSKaoydsfUn6ArbGZnYGA23vbYKg5nDBrzMWMiVJCalHeV4mxoxLkOWmhLwkRPj82b_kgiCOsK",
                    "secret" => "EBPu_lr7Cspi56clyJcfMkbxtctDh0e60yMBK5GOhsXRftUM1HlOoODS8nzbUpITWER-iVk89BAi0gTE",
                    "app_id" => "APP-80W284485P519543T",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "10.00000000",
                "name" => replaceInputTitle(GatewayName::BLOCK_CHAIN->value),
                "code" => GatewayCode::BLOCK_CHAIN->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "block-chain.png",
                "parameter" => [
                    "key" => "8df2e5a0-3798-4b74-871d-973615b57e7b",
                    "xpub_code" => "xpub6CXLqfWXj1xgXe79nEQb3pv2E7TGD13pZgHceZKrQAxqXdrC2FaKuQhm5CYVGyNcHLhSdWau4eQvq3EDCyayvbKJvXa11MX9i2cHPugpt3G",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "10.00000000",
                "name" => replaceInputTitle(GatewayName::COIN_GATE->value),
                "code" => GatewayCode::COIN_GATE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "coin-gate.png",
                "parameter" => [
                    "api_key" => "Ba1VgPx6d437xLXGKCBkmwVCEw5kHzRJ6thbGo-N",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "3.00000000",
                "rate" => "1.00000000",
                "name" => "Payment Solutions",
                "code" => Str::random(5),
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "atm-card.png",
                "parameter" => [
                    "trx" => [
                        "field_label" => "Trx",
                        "field_name" => "trx",
                        "field_type" => "text"
                    ],
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::MANUAL->value,
                "details" => "In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual",
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "3.00000000",
                "rate" => "1.00000000",
                "name" => "Bank Solutions",
                "code" => Str::random(5),
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "online-payment.png",
                "parameter" => [
                    "trx" => [
                        "field_label" => "Trx",
                        "field_name" => "trx",
                        "field_type" => "text"
                    ],
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::MANUAL->value,
                "details" => "In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual",
            ],
        ];

        PaymentGateway::truncate();
        collect($gateways)->each(fn($gateway) => PaymentGateway::create($gateway));
    }
}
