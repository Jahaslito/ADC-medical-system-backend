<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'date_of_birth' => 'required',
            'gender' => 'required|string',
            'address' => 'required',
            'town' => 'required',
            'phone_number' => 'required|string|min:10',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'date_of_birth' => $fields['date_of_birth'],
            'gender' => $fields['gender'],
            'address' => $fields['address'],
            'town' => $fields['town'],
            'phone_number' => $fields['phone_number'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' => $user,
            'token' => $token
        ];

        return responder()->success($response)->meta(['Message' => 'Registration successful']);

    }

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

        return responder()->success($response)->meta(['Message' => 'Login successful'])->respond(201);

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
