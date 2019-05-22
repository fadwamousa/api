<?php

use Faker\Generator as Faker;

use App\User;
use App\Product;
use App\Category;
use App\Seller;
use App\Buyer;
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::UNVERIFIED_USER,User::VERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1)
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' =>$faker->paragraph(1),//only one paragrah
        'quantity'    => $faker->numberBetween(1,10),
        'status'       => $faker->randomElement([Product::AVAILABL_PRODUCT,Product::UNAVAILABL_PRODUCT]),
        'image'        => $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        'seller_id'    => function(){
          return User::all()->random();
        }
    ];
});

$factory->define(App\Transaction::class, function (Faker $faker) {

    $seller = Seller::has('products')->get()->random();
    $buyer  = User::all()->except($seller->id)->random();

    return [
        'quantity'   => $faker->numberBetween(1,3),
        'product_id' => $seller->products->random()->id,
        'buyer_id'   => $buyer->id
    ];
});
/*
*
Sure, this is the deal.

A buyer is a User with at least one transaction (purchased something)
and a seller is a User who has at least one product (is selling something).

So, a transaction requires a buyer_id and a product_id.

Now, to obtain a seller we need to obtain a User with  product,
and we need to do that from the Seller model to get access to the products relationship,
and obtain only those with at least one product (we are going to improve that later).

Then, to obtain the seller, we have to do that directly to the User model,
as this may be the first purchase of that User so it is not a buyer yet.

Finally, we obtain the product_id from the products of the seller to be sure
that the buyer_id and the seller of that product are different ones, that is the reason
we except the id of the seller fro the collection of buyers.


*/
