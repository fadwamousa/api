<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{

    public function index(Buyer $buyer)
    {
        //

        $products = $buyer->transactions()
                          ->with('product')
                          ->get()
                          ->pluck('product');
                          //product is not collection instance of transactions
        return $this->showAll($products);
    }

}
