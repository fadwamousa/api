<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Product;
use App\Category;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::statement('SET FOREIGN_KEY_CHECKS =  0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();


        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();




        $userQTY = 150;
        $cateQTY = 30;
        $prodQTY = 250;
        $tranQTY = 200;

        factory(App\User::class,$userQTY)->create();

        factory(App\Category::class,$cateQTY)->create();

        factory(App\Product::class,$prodQTY)->create()->each(function($product){

          $categories = Category::all()->random(mt_rand(1,6))->pluck('id');

          $product->categories()->attach($categories);

        });

        factory(App\Transaction::class,$tranQTY)->create();
    }
}
