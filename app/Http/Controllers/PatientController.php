<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(){
        $patients = User::all();
        return responder()->success($patients)->respond();
    }

    public function show(Request $request){
        $details = $request->validate([
            'phone_number' => 'required|string|min:9',
        ]);

        $result = User::where('phone_number', 'LIKE', '%' . $details['phone_number'] . '%')->get();

        if (count($result)) {
            return responder()->success($result)->meta(['Message' => 'Patient found!']);
        }else{
            return responder()->error(404, 'Patient not found!')->respond(404);
        }
    }
}
