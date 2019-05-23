<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;
class UserController extends ApiController
{

    public function index()
    {
        //

        $users = User::all();
        return $this->showAll($users);
        //return response()->json(['data'=>$users],200);
    }



    public function store(Request $request)
    {
        //

        $rules = [
          'name'        => 'required',
          'email'       => 'required|email|unique:users',
          'password'    => 'required|min:6|confirmed'
        ];

        $this->validate($request,$rules);

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $input['verified'] = User::UNVERIFIED_USER;
        $input['verification_token'] = User::generateVerificationCode();
        $input['admin'] = User::REGULAR_USER;

        $user = User::create($input);

          return $this->showOne($users,201);

    }


    public function show(User $user)
    {
        //

          return $this->showOne($user);
    }


    public function update(Request $request, User $user)
    {
        //

        //$user  = User::findOrFail($id);

        $rules = [
          //to void the message the email is already exists
          'email'       => 'email|unique:users,email'.$user->id,
          'password'    => 'min:6|confirmed',
          'admin'       => 'in:'.User::ADMIN_USER .','.User::REGULAR_USER
          //the admin must be in two values only (0,1)
        ];

        if($request->has('name')){

          $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email){

          $user->verified = User::UNVERIFIED_USER;
          $user->verification_token = User::generateVerificationCode();
          $user->email    = $request->email;
        }

        if($request->has('password')){
          $user->password = bcrypt($request->password);
        }

        if($request->has('admin')){
          if(!$user->isVerified()){

            //409 has been confilected
            return $this->errorResponse('Only Verfied Users can modify the admin section',409);

          }

          $user->admin = $request->admin;
        }

       //if user change isDirty() return true
       //isClean() mean no change
       //isDirty() mean change
       if(!$user->isDirty()){

         return $this->errorResponse('The Data must be changed in update section',422);

       }

       $user->save();

         return $this->showOne($user);
    }


    public function destroy(User $user)
    {
        //
        //$user  = User::findOrFail($id);
        $user->delete();
        return $this->showOne($user);

    }
}
