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

        // {
        //     "sucess": true,
        //     "result": {
        //         "Token": "11|0o8AW9zxn5MCtyADGbGTzLTGnRCnBYOUlUtLCIYz9b02cb6c",
        //         "name": "manish"
        //     }
        // }
    }
    public function signup(Request $request)
    {
         $input = $request->all();
         $input['password'] = bcrypt($input['password']);
         $user = User::create($input);
         $sucess['Token'] = $user->createToken('MyApp')->plainTextToken;
         $sucess['name'] = $user->name;
         return ['sucess'=>true,'result'=>$sucess];

        //  {
        //     "sucess": true,
        //     "result": {
        //         "Token": "10|axQs7hl26BDZtpfeJANHFo2YzmTv9ta4wjcD275i366c4f4f",
        //         "name": "manish"
        //     }
        // }


    }
}
