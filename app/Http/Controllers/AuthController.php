<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'phone_number' => 'required|string|min:10',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
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

//    public function register(Request $request): \Illuminate\Http\JsonResponse
//    {
//        $validator = Validator::make($request->all(),[
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'phone_number' => 'required|string|min:10',
//            'password' => 'required|string|min:8|confirmed'
//        ]);
//
//        if($validator->fails()){
//            return response()->json($validator->errors());
//        }
//
//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'phone_number' => $request->phone_number,
//            'password' => Hash::make($request->password)
//        ]);
//
//        $token = $user->createToken('auth_token')->plainTextToken;
//
//        return response()
//            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
//    }

    public function test(REquest $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'phone number' => 'required|string'
        ]);

        return response("worked", 200);
    }

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

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
