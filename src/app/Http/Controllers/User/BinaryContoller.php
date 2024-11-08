<?php

namespace App\Http\Controllers\User;

use App\Lib\Binary;
use App\Models\Stock;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\Commodity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Binary as ModelBinary;

class BinaryContoller extends Controller
{

    public function commodities()
    {

        $data = [
            'setTitle' => 'Commodities',
            'commoditys' => Commodity::paginate(getPaginate())
        ];

        return view('user.binary.commodities')->with($data);
    }

    public function forex()
    {
        $data = [
            'setTitle' => 'Forex',
            'forexs' => Currency::paginate(getPaginate())
        ];

        return view('user.binary.forex')->with($data);
    }

    public function stocks()
    {
        $data = [
            'setTitle' => 'Stocks',
            'stocks' => Stock::paginate(getPaginate())
        ];

        return view('user.binary.stocks')->with($data);
    }

    public function trade(string $type, string $symbol)
    {

        if (strpos(strtolower($symbol), 'usd') == false && $type !== "stock" && $type !== "commodity") {
            $pair = strtoupper($symbol) . "USD";
        } else {
            $pair = strtoupper($symbol);
        }

        $data = [
            'setTitle' => 'Trade  ' . strtoupper($type),
            'symbol' => $symbol,
            'type' => $type,
            'pair' => $pair,
            'tradeLogs' => ModelBinary::where('user_id', auth()->user()->id)->paginate(getPaginate()),
            'wallet' => Wallet::where('user_id', auth()->user()->id)->first()
        ];



        return view('user.binary.trade')->with($data);
    }

    public function tradeStock(Request $request)
    {
        $binary = new Binary(isStock: true);
        return $binary->store($request);
    }
    public function tradeCommodity(Request $request)
    {
        $binary = new Binary(isCommodity: true);
        return $binary->store($request);
    }

    public function tradeForex(Request $request)
    {
        $binary = new Binary(isForex: true);
        return $binary->store($request);
    }

    public function history()
    {
        return response()->json(ModelBinary::where('user_id', auth()->user()->id)->get());
    }

    public function end($id)
    {
        $trade = ModelBinary::where('id', (int) $id)->first();
        $wallet = Wallet::where('user_id', $trade->user_id)->first();

        if (!$trade || !$wallet) {
            $notify[] = ['error', 'invalid action'];
            return back()->withNotify($notify);
        }

        $balance = max(0, $trade->amount);

        try {
            DB::beginTransaction();

            // Close the trade and update wallet balance
            $trade->status = true;
            $wallet->trade_balance += $balance;

            $trade->save();
            $wallet->save();

            DB::commit();
            $notify[] = ['success', 'Trade Closed Successfully'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] =  ['error', $trade->id . ': ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }
}
