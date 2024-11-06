<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\Binary;
use App\Models\Commodity;
use App\Models\Currency;
use App\Models\Stock;
use Illuminate\Http\Request;

class BinaryContoller extends Controller
{
    public function index() {}

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

    public function trade(string $type, string $symbol) {}

    public function tradeStock(Request $request)
    {
        $binary = new Binary(isStock: true);
        return $binary->store($request);
    }
}
