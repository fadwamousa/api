
<?php

use Illuminate\Http\Request;

/*
* Buyer
*show me the index page and show page only
*/

Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);

/*
* Category
* show me the all pages except the create and edit pages
*/
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
/*
* Product
*/
Route::resource('products','Product\ProductController',['only'=>['index','show']]); //show me the index page and show page only

/*
* Seller
*/
Route::resource('sellers','Seller\SellerController',['only'=>['index','show']]); //show me the index page and show page only


/*
* transaction
*/
Route::resource('transaction','Transaction\TransactionController',['only'=>['index','show']]); //show me the index page and show page only

/*
* user
*/
Route::resource('users','User\UserController',['except'=>['create','edit']]); //show me the index page and show page only
