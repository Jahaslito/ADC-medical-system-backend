<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\LabTechnitian;
use App\Models\Nurse;
use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffRegistration extends Controller
{
    public function verify_staff($staff_id, Request $request)
    {
        $role = $request->validate([
            'role' => 'required'
        ]);
        $result=null;
        if ($role['role'] == 'Doctor') {
            $result = Doctor::where('id', 'LIKE', '%' . $staff_id . '%')->get();
        }elseif ($role['role'] == 'Nurse'){
            $result = Nurse::where('id', 'LIKE', '%' . $staff_id . '%')->get();
        }elseif ($role['role'] == 'Lab technician'){
            $result = LabTechnitian::where('id', 'LIKE', '%' . $staff_id . '%')->get();
        }elseif ($role['role'] == 'Receptionist'){
            $result = Receptionist::where('id', 'LIKE', '%' . $staff_id . '%')->get();
        }else{
            return responder()->error(404, 'Staff category not found!')->respond(404);
        }

        if(count($result)){
            return responder()->success($result->toArray())->meta(['Message' => 'Staff id found!']);
        }
        else
        {
            return responder()->error(404, 'Staff id not found!')->respond(404);
        }
    }

    public function register_staff(Request $request)
    {
        $creds = $request->validate([
            'id' => 'required',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required'
        ]);

        if ($creds['role'] == 'Doctor') {
            $result = Doctor::where('id', 'LIKE', '%' . $creds['id'] . '%')->get();
        }elseif ($creds['role'] == 'Nurse'){
            $result = Nurse::where('id', 'LIKE', '%' . $creds['id'] . '%')->get();
        }elseif ($creds['role'] == 'Lab technician'){
            $result = LabTechnitian::where('id', 'LIKE', '%' . $creds['id'] . '%')->get();
        }elseif ($creds['role'] == 'Receptionist'){
            $result = Receptionist::where('id', 'LIKE', '%' . $creds['id'] . '%')->get();
        }else{
            return responder()->error(404, 'Staff category not found!')->respond(404);
        }

        if (count($result) && $creds['role'] == 'Doctor'){
            DB::table('doctors') ->where('id', $creds['id'])
                ->update(['password' => bcrypt($creds['password'])]);
            return responder()->success($result->toArray())->meta(['Message' => 'Staff registration successful!']);
        }elseif (count($result) && $creds['role'] == 'Nurse'){
            DB::table('nurses') ->where('id', $creds['id'])
                ->update(['password' => bcrypt($creds['password'])]);
            return responder()->success($result->toArray())->meta(['Message' => 'Staff registration successful!']);
        }elseif (count($result) && $creds['role'] == 'Lab technician'){
            DB::table('lab_technicians') ->where('id', $creds['id'])
                ->update(['password' => bcrypt($creds['password'])]);
            return responder()->success($result->toArray())->meta(['Message' => 'Staff registration successful!']);
        }elseif (count($result) && $creds['role'] == 'Receptionist'){
            DB::table('receptionists') ->where('id', $creds['id'])
                ->update(['password' => bcrypt($creds['password'])]);
            return responder()->success($result->toArray())->meta(['Message' => 'Staff registration successful!']);
        } else{
            return response()->json('Registration failed. Kindly check your staff id', 401);
        }


    }

    public function login_staff(Request $request){
        $fields = $request->validate([
            'id' => 'required|integer',
            'password' => 'required|string',
            'role' => 'required'
        ]);

        if ($fields['role'] == 'Doctor') {
            $doctor = Doctor::where('id', $fields['id'])->first();

            if (!$doctor || !Hash::check($fields['password'], $doctor->password)) {
                return response([
                    'message' => 'The credentials do not match our records'
                ], 401);
            }

            $token = $doctor->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $doctor,
                'token' => $token
            ];
            return responder()->success($response)->meta(['Message' => 'Staff logged in successfully!']);

        }elseif ($fields['role'] == 'Nurse'){
            $nurse = Nurse::where('id', $fields['id'])->first();

            if (!$nurse || !Hash::check($fields['password'], $nurse->password)) {
                return response([
                    'message' => 'The credentials do not match our records'
                ], 401);
            }

            $token = $nurse->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $nurse,
                'token' => $token
            ];
            return responder()->success($response)->meta(['Message' => 'Staff logged in successfully!']);

        }elseif ($fields['role'] == 'Lab technician'){
            $lab_tech = LabTechnitian::where('id', $fields['id'])->first();

            if (!$lab_tech || !Hash::check($fields['password'], $lab_tech->password)) {
                return response([
                    'message' => 'The credentials do not match our records'
                ], 401);
            }

            $token = $lab_tech->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $lab_tech,
                'token' => $token
            ];
            return responder()->success($response)->meta(['Message' => 'Staff logged in successfully!']);

        }elseif ($fields['role'] == 'Receptionist'){
            $receptionist = Receptionist::where('id', $fields['id'])->first();

            if (!$receptionist || !Hash::check($fields['password'], $receptionist->password)) {
                return response([
                    'message' => 'The credentials do not match our records'
                ], 401);
            }

            $token = $receptionist->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $receptionist,
                'token' => $token
            ];
            return responder()->success($response)->meta(['Message' => 'Staff logged in successfully!']);

        }else {
            return responder()->error(404, 'These credentials do not march our records!');
        }
    }
}
