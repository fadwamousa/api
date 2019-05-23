<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{

    public function index(Buyer $buyer)
    {
        //

        // unique(id) for seller
        //because seller may be selling several different products .
        //and the buyer can buy many different products from the same seller
        //So, based on that,
        //we know we can obtain repeated sellers at any moment so we need to
        //remove that ones and get unique values.

        $sellers = $buyer->transactions()
        ->with('product.seller')
        ->get()
        ->pluck('product.seller')
        ->unique('id')
        ->values();
        return $this->showAll($sellers);

    }


}
