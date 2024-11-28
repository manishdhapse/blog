<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use  Illuminate\Support\Facades\Hash;

class UserAuthControllers extends Controller
{
    //
    public function login(Request $request)
    {
        $input = $request->all();
        $user = User::where('email',$request->email)->first();
        if(!$user || ! Hash::check($request->password, $user->password)){
            return ["res" => 'user not there'];
        }else{
            $sucess['Token'] = $user->createToken('MyApp')->plainTextToken;
            $sucess['name'] = $user->name;
            return ['sucess'=>true,'result'=>$sucess];
        }
       // print_r($input);
        return $input;
    }
    public function signup(Request $request)
    {
         $input = $request->all();
         $input['password'] = bcrypt($input['password']);
         $user = User::create($input);
         $sucess['Token'] = $user->createToken('MyApp')->plainTextToken;
         $sucess['name'] = $user->name;
         return ['sucess'=>true,'result'=>$sucess];


    }
}
