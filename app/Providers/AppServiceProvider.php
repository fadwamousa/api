<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::created(function($user){

          retry(5,function() use($user){
            Mail::to($user)->send(new UserCreated($user));
          },100);

          //retry will 5 times again and again 5 times the email thay in function
          //every 100 mile second

        });

        User::updated(function($user){

          if($user->isDirty('email')){

            retry(5,function() use($user){
              Mail::to($user)->send(new UserMailChanged($user));
            },100);

          }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
