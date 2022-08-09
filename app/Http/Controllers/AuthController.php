<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request) {

        try {
            //code...
            $validatedUser = Validator::make($request->all(), [
                'firstName' => 'required|string',
                'lastName' => 'required|String',
                'email' => 'required|email|unique:App\Models\User,email',
                'password' => 'required|string|min:6'
            ]); 
    
            if($validatedUser->fails()){
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validatedUser -> errors()
                ], 401);
            }
    
            $inputs = $request->all();
            $inputs["password"] = Hash::make($request->password);
    
            $user   =   User::create($inputs);
    
            if(is_null($user)){
                return response()->json([
                    'status'=>'failed',
                    "message"=>"Failed to sign up user, please try again"
                ], 400);
            }
    
            $token  = $user->createToken('token')->plainTextToken;
    
             $response = [
                'status' => 'success',
                'user' => $user,
                'token' => $token
            ];
    
            return response($response, 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>"fail",
                "message"=>$th->getMessage()
            ], 500);
        }
    }


    public function signin(Request $request) {
        try {
            //code...
            $validatedUser = Validator::make($request->all(), [
                'email'=>'required|email',
                'password'=>'required'
            ]);
    
            if($validatedUser->fails()){
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validatedUser -> errors()
                ], 401);
            }
    
            // get user arry by email
            $user = User::where('email', $request['email'])->first();
    
            // check if user exist and passowrd match
            if(!$user){
                return response()->json([
                    'status' => 'failed',
                    'errors' => 'Email not does not exits'
                ], 401);
            }
    
            if(!Hash::check($request['password'], $user->password)){
                return response()->json([
                    'status' => 'failed',
                    'errors' => 'password incorret'
                ], 401);
            }
    
            // all clear
            $token  = $user->createToken('token')->plainTextToken;
    
            $response = [
                'status' => 'success',
                'user' => $user,
                'token' => $token
            ];
    
            return response($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>"fail",
                "message"=>$th->getMessage()
            ], 500);
        }
    }



     // User Detail
     public function user() {
        // $user =  Auth::user();
        try {
            //code...
            $user  =  Auth::user();
            if(is_null($user)) { 
                return response()->json([
                    "status"=>"success",
                    "message" => "User not found"
                ], 400);
            }

            return response()->json([
                "status"=>"success",
                "data" => $user
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>"fail",
                "message"=>$th->getMessage()
            ], 500);
        }

              
    }

}
