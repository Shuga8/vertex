<?php

namespace App\Lib;


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

    public function store($request) {}
}
