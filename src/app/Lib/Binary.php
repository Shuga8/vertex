<?php

namespace App\Lib;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Binary as ModelsBinary;
use Illuminate\Support\Facades\Validator;

class Binary
{

    public $isCommodity;
    public $isForex;
    public $isStock;

    public function __construct($isCommodity = false, $isForex = false, $isStock = false)
    {
        $this->isCommodity = $isCommodity;
        $this->isForex = $isForex;
        $this->isStock = $isStock;
    }

    public function store($request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $wallet = Wallet::where('user_id', $user->id)->first();

        if ($this->isCommodity) {
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric'],
                'stop_loss' => ['required', 'numeric'],
                'take_profit' => ['required', 'numeric'],
                'rate' => ['required', 'numeric'],
                'action' => ['required', 'string', 'in:buy,sell'],
                'symbol' => ['required', 'string', 'exists:commodities,symbol'],
            ]);
        } else if ($this->isForex) {
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric'],
                'stop_loss' => ['required', 'numeric'],
                'take_profit' => ['required', 'numeric'],
                'rate' => ['required', 'numeric'],
                'action' => ['required', 'string', 'in:buy,sell'],
                'symbol' => ['required', 'string', 'exists:currencies,symbol'],
            ]);
        } else if ($this->isStock) {
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric'],
                'stop_loss' => ['required', 'numeric'],
                'take_profit' => ['required', 'numeric'],
                'rate' => ['required', 'numeric'],
                'action' => ['required', 'string', 'in:buy,sell'],
                'symbol' => ['required', 'string', 'exists:stocks,symbol'],
            ]);
        } else {
            $notify[] = ['warning', "Invalid action"];
            return back()->withNotify($notify);
        }

        if ($validator->fails()) {
            $notify[] = ['error', $validator->errors()->first()];
            return back()->withNotify($notify);
        }

        $balance  = $wallet->trade_balance;

        if ($request->amount >= $balance) {
            $notify[] = ['warning', 'Insufficient balance'];
            return back()->withNotify($notify);
        }

        try {
            DB::beginTransaction();

            $binary = new ModelsBinary();
            $transaction = new Transaction();

            $binary->user_id = $user->id;
            $transaction->user_id = $user->id;
            $binary->amount = $request->amount;
            $transaction->amount = $request->amount;
            $binary->open_amount = $request->amount;
            $binary->open_price = $request->rate;
            $binary->stop_loss = $request->stop_loss;
            $binary->take_profit = $request->take_profit;
            $binary->trade_type = $request->action;
            if ($request->amount >= 1000) {
                $binary->pips = 10;
            } else if ($request->amount >= 100) {
                $binary->pips = 1;
            } else {
                $binary->pips = 0.5;
            }
            $binary->price_was = $request->rate;
            if ($this->isCommodity) {
                $binary->isCommodity = true;
                $binary->commodity = strtoupper($request->symbol);
            } else if ($this->isForex) {
                $binary->isForex = true;
                $binary->forex = strtoupper($request->symbol);
            } else if ($this->isStock) {
                $binary->isStock = true;
                $binary->stock = strtoupper($request->symbol);
            }

            $balance -= $request->amount;
            $wallet->trade_balance = $balance;
            $transaction->post_balance = $balance;
            $transaction->trx = strtoupper(Str::random(12));
            $transaction->type = 2;
            $transaction->wallet_type = 3;
            $transaction->source = 5;
            $transaction->details = "Trade " .  strtoupper($request->symbol) . " " . strtoupper($request->action) . " at $$request->amount";


            $binary->save();
            $wallet->save();
            $transaction->save();
            DB::commit();
            $notify[] = ['success', 'trade started successfully'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {

            DB::rollBack();
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }
}
