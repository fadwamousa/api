<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    //

    use SoftDeletes;
    protected $dates = ['deleted_at'];

     const AVAILABL_PRODUCT   = 'available';
     const UNAVAILABL_PRODUCT = 'unavailable';


      protected $fillable = [

                    'name',
                    'description',
                    'quantity',
                    'status', // only two values (0,1)
                    'image',
                    'seller_id'

      ]; //mass assignment



      public function isAvailable(){

        return $this->status == Product::AVAILABL_PRODUCT;
      }


      public function categories(){
        return $this->belongsToMany(Category::class);
      }


      public function seller(){
        return $this->belongsTo(Seller::class);
      }

      public function transactions(){
        return $this->hasMany(Transaction::class);
      }
}
