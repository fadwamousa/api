<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class ProductBuyerTransactionController extends ApiController
{

  // store the transaction for specific the buyer for specific product
    public function store(Request $request,Product $product , User $buyer)
    {

        $this->validate($request,[
          'quantity' => 'required|integer|min:1'
      ]);

        //البائع مثل المشتري وهذا يسبب مشكلة
        if($product->seller_id == $buyer->id){

          return $this->errorResponse('The Buyer must be different the seller',409);

        }

        //the user buyer and the seller are verified

        if(!$buyer->isVerified()){
          return $this->errorResponse('The Buyer must be verified to complete this is action',409);
        }

        //the seller user must be verified
        if(!$product->seller->isVerified()){
          return $this->errorResponse('The Seller must be verified to complete this is action',409);
        }

        // product must be avaliable
        if(!$product->isAvailable()){
          return $this->errorResponse('The Product be verified to complete this is action',409);
        }

        if($product->quantity < $request->quantity){
          return $this->errorResponse('The quantity must be greater than the requset',409);
        }

        return DB::transaction(function() use ($request,$product,$buyer){
          $product->quantity = $request->quantity;
          $product->save();

          $transaction = Transaction::create([
            'quantity'=>$request->quantity,
            'buyer_id'=>$buyer->id,
            'product_id'=>$product->id
          ]);

          return $this->showOne($transaction,201);
        });
    }

}
