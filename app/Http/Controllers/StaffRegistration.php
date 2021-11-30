<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffRegistration extends Controller
{
    public function verify_staff($staff_id): \Illuminate\Http\JsonResponse
    {
        $result = Doctor::where('id', 'LIKE', '%'. $staff_id. '%')->get();
        if(count($result)){
            $response = str_replace("'", "\'", json_encode($result));
            return response()->json($response.' Staff id found', '200');
        }
        else
        {
            return response()->json(['Result' => 'Staff id not found'], 404);
        }
    }

    public function register_staff(Request $request): \Illuminate\Http\JsonResponse
    {
        $creds = $request->validate([
            'id' => 'required',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $result = Doctor::where('id', 'LIKE', '%'. $creds['id']. '%')->get();

        if (count($result)){
            DB::table('doctors') ->where('id', $creds['id'])
                ->update(['password' => bcrypt($creds['password'])]);
            return response()->json($result->toArray().' Staff registered successfully', '200');
        }else{
            return response()->json('Registration failed. Kindly check your staff id', 401);
        }


    }

    public function login_staff(Request $request){
        dd('test');
        $fields = $request->validate([
            'id' => 'required|integer',
            'password' => 'required|string'
        ]);

        $doctor = Doctor::where('id', $fields['id'])->first();

        if (!$doctor || !Hash::check($fields['password'], $doctor->password)){
            return response([
                'message' => 'The credentials do not match our records'
            ], 401);
        }

        $token = $doctor->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' => $doctor,
            'token' => $token
        ];

        return response($response, 200);
    }
}
