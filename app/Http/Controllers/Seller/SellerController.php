<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Seller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $seller = Seller::has('products')->get();
        return response()->json(['data'=>$seller]);
    }

    public function show($id)
    {
        //

        $seller = Seller::has('products')->findOrFail($id);
        return response()->json(['data'=>$seller]);
    }


}
