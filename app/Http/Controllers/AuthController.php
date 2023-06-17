<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\OnlyUserResource;
use App\Models\Task;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => "successfully created an account",
            'data' => OnlyUserResource::make($user)
        ], 200);

    }

    public function login(LoginRequest $request){

        $user = User::where('email', $request->email)->first();
        if($user){

            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'message' => "successfully logged in",
                    'token' => $token,
                    'data' => OnlyUserResource::make($user)
                ], 200);
            }

        }else{

            return response()->json([
                'message' => "email or password is incorrect",
            ], 400);

        }
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'successfully logged out',
        ], 200);

    }

    public function user(){

        return response()->json([
            'message' => 'successfully fetched the user',
            'data' => OnlyUserResource::make(auth()->user())
        ], 200);

    }

}
