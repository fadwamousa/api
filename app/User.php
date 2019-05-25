<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    const VERIFIED_USER     =   1  ;
    const UNVERIFIED_USER   =   0  ;

    const  ADMIN_USER   = 'true'  ;
    const  REGULAR_USER = 'false' ;

    protected $table = 'users'; //becaues the seller and buyer extends frm user

    protected $fillable = [
        'name', 'email', 'password','verification_token','admin','verified'
    ];


    protected $hidden = [
        'password', 'remember_token'
        //'verification_token'
    ];

    //Mautotrs
    public function setNameAttribute($name){
      return $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute($email){
      return $this->attributes['email'] = strtolower($email);
    }

    public function getNameAttribute($name){
      return ucwords($name);
    }



    public function isVerified(){
      return $this->verified == User::VERIFIED_USER;
    }


    public function isAdmin(){
      return $this->admin == User::ADMIN_USER;
    }

    public static function generateVerificationCode(){
      return str_random(40);
    }
}
