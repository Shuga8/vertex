<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $setting = SettingService::getSetting();

        return ApiJsonResponse::success('Setting api', [
            'site_title' => getArrayValue($setting->appearance, 'site_title'),
            'white_logo' => displayImage(getArrayValue($setting?->logo, 'white'), "592x89"),
            'dark_logo' => displayImage(getArrayValue($setting?->logo, 'white'), "592x89"),
            'trade_practice_balance' => getArrayValue($setting->commissions_charge, 'trade_practice_balance'),
            'currency_name'=> getCurrencyName(),
            'currency_symbol'=> getCurrencySymbol(),
            'investment_setting' => $setting->investment_setting
        ]);
    }
}
