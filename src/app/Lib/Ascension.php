<?php

namespace App\Lib;

use App\Models\Binary;
use App\Models\Wallet;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Ascension
{
    private $fast_forex_api_key;
    private $fmp_api_key;

    public function __construct()
    {
        $this->fast_forex_api_key = '5952fd138c-5327d8b2a6-smk0x3';
        $this->fmp_api_key = "cARpiP1yH7faNhSWqnQLyGNV0mc7oTxl";
    }


    private function connectIexCloud($symbol)
    {
        $url = "https://financialmodelingprep.com/api/v3/profile/$symbol?apikey=" . $this->fmp_api_key;
        $client = new Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        if (isset($data[0]["price"])) {
            return $data[0]["price"];
        } else {
            Log::error("No price for $symbol");
            return null;
        }
    }

    private function connectCommodity($symbol)
    {
        $url = "https://financialmodelingprep.com/api/v3/quote/$symbol?apikey=" . $this->fmp_api_key;
        $client = new Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        if (isset($data[0]["price"])) {
            return $data[0]["price"];
        } else {
            Log::error("No price for $symbol");
            return null;
        }
    }

    private function connectFastForex($symbol)
    {
        $url = "https://api.fastforex.io/convert?from=$symbol&to=USD&amount=1&api_key=$this->fast_forex_api_key";
        $client = new Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Error decoding Fast Forex response: ' . json_last_error_msg());
            return null;
        }

        if (!isset($data['result']['rate'])) {
            Log::error('Fast Forex response does not contain rate for ' . $symbol);
            return null;
        }

        return (float) $data['result']['rate'];
    }

    public function updatePriceIs()
    {
        $trades = Binary::where('status', false)->get();

        if ($trades->isEmpty()) {
            Log::info('No trades with status running found.');
            return false;
        }

        foreach ($trades as $trade) {
            try {
                DB::beginTransaction();
                Log::info('Processing trade ID: ' . $trade->id);

                $rate = null;
                if ($trade->isForex) {
                    $rate = $this->connectFastForex($trade->forex);
                } elseif ($trade->isStock) {
                    $rate = $this->connectIexCloud($trade->stock);
                } elseif ($trade->isCommodity) {
                    $rate = $this->connectCommodity($trade->commodity);
                }

                if ($rate !== null) {
                    $trade->price_is = $rate;
                    Log::info('Updated price for trade ID: ' . $trade->id . ' to ' . $trade->price_is);
                    $trade->save();
                    DB::commit();
                } else {
                    DB::rollBack();
                    Log::warning('Rate is null for trade ID: ' . $trade->id);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error processing trade ID ' . $trade->id . ': ' . $e->getMessage());
            }
        }

        return true;
    }

    public function setPips()
    {
        $trades = Binary::where('status', false)->get();


        foreach ($trades as $trade) {
            try {
                DB::beginTransaction();
                Log::info('Processing trade ID: ' . $trade->id);

                if (is_null($trade->price_is) || $trade->price_is === 0.00000000) {
                    Log::warning('Skipping trade ID: ' . $trade->id . ' due to null or zero price_is');
                    continue;
                }

                $pips = (float) $trade->pips;

                if ($trade->amount <= 0 || $trade->price_is >= $trade->take_profit || $trade->price_is <= $trade->stop_loss) {
                    $bal = $trade->amount;
                    $this->updateStatusAndBalance($trade->id, $bal);
                    DB::commit();
                    continue;
                }

                if ($trade->trade_type === "buy") {
                    $trade->amount += ($trade->price_is > $trade->price_was) ? $pips : -$pips;
                } else if ($trade->trade_type === "sell") {
                    $trade->amount += ($trade->price_is < $trade->price_was) ? $pips : -$pips;
                }

                $trade->price_was = $trade->price_is;
                $trade->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error processing trade ID ' . $trade->id . ': ' . $e->getMessage());
            }
        }

        Log::info('Pips calculated and completed');
    }

    public function updateStatusAndBalance($id, float $balance)
    {

        if ($balance < 0) {
            $balance = 0.000000;
        }

        $trade = Binary::find($id);
        $wallet = Wallet::where('user_id', $trade->user_id)->first();

        try {
            DB::beginTransaction();
            Log::info('Processing trade ID: ' . $trade->id);

            $trade->status = true;
            $wallet->trade_balance +=  $balance;

            $trade->save();
            $wallet->save();

            DB::commit();
            Log::info('Statuses and balances updated');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating status and balance for trade ID ' . $trade->id . ': ' . $e->getMessage());
            return false;
        }
    }
}
