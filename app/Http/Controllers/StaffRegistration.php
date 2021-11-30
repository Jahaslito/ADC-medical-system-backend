<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffRegistration extends Controller
{
    public function verify_staff($staff_id): \Illuminate\Http\JsonResponse
    {
        $result = Doctor::where('id', 'LIKE', '%'. $staff_id. '%')->get();
        if(count($result)){
            return response()->json($result.'Staff id found', '200');
        }
        else
        {
            return response()->json(['Result' => 'Staff id not found'], 404);
        }
    }

    public function register_staff(Request $request){
        $creds = $request->validate([
            'password' => 'required|string|confirmed|min:8'
        ]);


    }
}
