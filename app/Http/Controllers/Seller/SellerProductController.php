<?php

namespace App\Http\Controllers\Seller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Product;
use App\User;
class SellerProductController extends ApiController
{

     public function index(Seller $seller)
     {
         //
         $products  = $seller->products;
         return $this->showAll($products);
     }


    public function store(Request $request,User $seller)
    {
        //

        $rules = [
          'name' => 'required',
          'description' => 'required',
          'quantity'    => 'required|integer',
          'image'       => 'required|image'
        ];

        $this->validate($request,$rules);
        $data = $request->all();
        $data['status'] = Product::UNAVAILABL_PRODUCT;
        //here upload the image using store method that taking two paramaeters one (path) but we already write in file_system and the seconed parameters is the disk that already write also in file file_system
        $data['image']  = $request->image->store('');
        // store(path,disk) //path created in file system && disk is default in file system
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);
        return $this->showOne($product);
    }


    public function update(Request $request , Seller $seller , Product $product)
    {
          $rules = [
            'quantity'    => 'integer|min:1',
            'status'      => 'in: '. Product::UNAVAILABL_PRODUCT . ',' . Product::AVAILABL_PRODUCT,
            'image'       => 'image'
          ];

          $this->validate($request,$rules);
          $this->checkSeller($seller , $product);
          $product->fill($request->only(['name','description','quantity']));

          if($request->has('status')){
            $product->status = $request->status;

            if($product->isAvailable() && $product->categories()->count() == 0){

              return $this->errorResponse('An active product must be a least one category',409);
            }
          }

          if($request->hasFile('image')){
             Storage::delete($product->image);
             $product->image=$request->image->store('');
           }

          if($product->isClean()){
              return $this->errorResponse('No Cahnge happen must be change some data in update section',422);
          }

          $product->save();
          return $this->showOne($product);
    }

    public function destroy(Seller $seller,Product $product)
    {
        $this->checkSeller($seller , $product);

        $product->delete();

        Storage::delete($product->image);
        //we can put this is command before but we want to remove image definitly
        //will remove the image from the folder

        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller , Product $product){

      if($seller->id != $product->seller_id){
         throw new HttpException(422,'The specified Seller is not the actual seller of the product');
      }
    }
}
