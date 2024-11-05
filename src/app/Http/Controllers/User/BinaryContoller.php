<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class BinaryContoller extends Controller
{
    public function index() {}

    public function commodities()
    {

        $data = [
            'setTitle' => 'Binary | Commodities',
            'commoditys' => Commodity::paginate(getPaginate())
        ];

        return view('uer.binary.commodities')->with($data);
    }

    public function forex() {}

    public function trade(Request $request) {}
}
