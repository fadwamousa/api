
<?php

use Illuminate\Http\Request;

/*
* Buyer
*show me the index page and show page only
*/

Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);
Route::resource('buyers.transactions','Buyer\BuyerTransactionController',['only'=>['index']]);
Route::resource('buyers.products','Buyer\BuyerProductController',['only'=>['index']]);
Route::resource('buyers.sellers','Buyer\BuyerSellerController',['only'=>['index']]);
Route::resource('buyers.categories','Buyer\BuyerCategoryController',['only'=>['index']]);


/*
* Category
* show me the all pages except the create and edit pages
*/
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('categories.products','Category\CategoryProductController',['only'=>['index']]);
Route::resource('categories.sellers','Category\CategorySellerContoller',['only'=>['index']]);
Route::resource('categories.transactions','Category\CategoryTransactionContoller',['only'=>['index']]);

Route::resource('categories.buyers','Category\CategoryBuyerContoller',['only'=>['index']]);

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
Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]); //show me the index page and show page only
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only'=>['index']]); //show me the index page and show page only
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only'=>['index']]); //show me the index page and show page only

/*
* user
*/
Route::resource('users','User\UserController'); //show me the index page and show page only
