<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Product;

class ProductController extends ApiController
{

    public function index()
    {
        //

        $product = Product::all();
        return $this->showAll($product);
    }


    public function show(Product $product)
    {
        //$product = Product::findOrFail($id);
        return $this->showOne($product);
    }


}
