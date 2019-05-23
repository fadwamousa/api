<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionContoller extends ApiController
{

    public function index(Category $category)
    {
        $transactions = $category->products()
                                 ->whereHas('transactions')
                                 ->with('transactions')
                                 ->get()
                                 ->pluck('transactions')
                                 ->collapse()
                                 ->unique('id')
                                 ->values();


        return $this->showAll($transactions);
    }


}
