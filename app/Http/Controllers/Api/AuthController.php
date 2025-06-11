<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return response()->json([
            'status'=>'200',
            'Message'=>"User register successfully",
            'token'=>$user->createToken('api-token')->plainTextToken,
        ]);
    }



    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password , $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token'=>$user->createToken('api-token')->plainTextToken,
        ]);

    }



    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'status'=>'200',
            'Message'=>"User logout successfully",
        ]);
    }


    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status'=>'200',
            'Message'=>"Refresh token successfully",
            'token'=>$token,
        ]);

    }
}
