<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    // Register function
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'phone_number' => 'required|string|min:10',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone_number' => $fields['phone_number'],
            'password' => bcrypt($fields['password'])
        ]); 

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }

    // Test
    public function test(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'phone number' => 'required|string'
        ]);

        return response("worked", 200);
    }

    // Login function
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

       $user = User::where('email', $fields['email'])->first();

       if (!$user || !Hash::check($fields['password'], $user->password)){
           return response([
                'message' => 'The credentials do not match our records'
           ], 401);
       }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }

    // Logout function
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
