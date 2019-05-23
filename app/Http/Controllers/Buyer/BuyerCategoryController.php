<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{

    public function index(buyer $buyer)
    {
        //

        $category = $buyer->transactions()
                          ->with('product.categories')
                          ->get()
                          ->pluck('product.categories')
                          ->unique('id')
                          ->values()
                          ->collapse();
       return $this->showAll($category);
    }


}
