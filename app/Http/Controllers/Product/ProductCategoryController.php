<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{

  //  get me all the categories for specific product

    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        //Many To Many (attach & detach & sync) && syncWithoutDetach
        $product->categories()->attach([$category->id]);
        return $this->showAll($product->categories);
    }

    public function destroy(Product $product,Category $category)
    {
        if(!$product->categories()->find($category->id)){
          return $this->errorResponse('category id is not in list of categories',404);
        }

        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }








}
