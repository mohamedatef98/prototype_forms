<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 400);
        }

        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = auth()->attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);

    }

    public function signup(Request $request){
        $validator = Validator::make($request->all() ,[
            'username'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|confirmed'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 400);
        }

        $user = new \App\User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        $user->save();

        return response()->json(['success'=>true, 'data'=>$user]);
    }

    public function logout(Request $request){

    }
}
