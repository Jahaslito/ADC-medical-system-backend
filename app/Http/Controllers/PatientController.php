<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index(){
        $patients = User::all();
        return responder()->success($patients)->respond();
    }

    public function show(Request $request){
        $details = $request->validate([
            'phone_number' => 'required|string',
        ]);

        $result = User::where('phone_number', 'LIKE', '%' . $details['phone_number'] . '%')->get();

        if (count($result)) {
            return responder()->success($result)->meta(['Message' => 'Patient found!']);
        }else{
            return responder()->error(404, 'Patient not found!')->respond(404);
        }
    }

    public function search(Request $request){
        $patient = $request->validate([
            'id' => 'required',
        ]);

        $result = User::where('id', $patient['id'])->get();

        if (count($result)) {
            return responder()->success($result)->meta(['Message' => 'Patient found!']);
        }else{
            return responder()->error(404, 'Patient not found!')->respond(404);
        }
    }

    public function update_patient($patient_id, Request $request) {
        $this->validate($request, [
            'first_name',
            'last_name',
            'email',
            'password' => 'string|confirmed|min:8',
            'phone_number',
            'date_of_birth',
            'address',
            'town',
            'gender'
        ]);

        $user = new User;
        $user_records = DB::table('users')
                            ->where('id', $patient_id)
                            ->get();

        $user_records = json_decode($user_records);

        if ($request->has('first_name')) {
            $user->first_name = $request->get('first_name');
        } else {
            $user->first_name = $user_records[0]->first_name;
        }

        if ($request->has('last_name')) {
            $user->last_name = $request->get('last_name');
        } else {
            $user->last_name = $user_records[0]->last_name; 
        }

        if ($request->has('email')) {
            $user->email = $request->get('email');
        } else {
            $user->email = $user_records[0]->email;
        }

        if ($request->has('phone_number')) {
           $user->phone_number = $request->get('phone_number');
        } else {
            $user->phone_number = $user_records[0]->phone_number; 
        }

        if ($request->has('date_of_birth')) {
            $user->date_of_birth = $request->get('date_of_birth');
        } else {
            $user->date_of_birth = $user_records[0]->date_of_birth;
        }

        if ($request->has('address')) {
            $user->address = $request->get('address');
        } else {
            $user->address = $user_records[0]->address;
        }

        if ($request->has('town')) {
            $user->town = $request->get('town');
        } else {
            $user->town = $user_records[0]->town;
        }

        if ($request->has('gender')) {
            $user->gender = $request->get('gender');
        } else {
            $user->gender = $user_records[0]->gender;
        }

        $update = User::where('id', $patient_id)->update(['first_name'=>$user->first_name, 'last_name'=>$user->last_name, 'email'=>$user->email,  'phone_number'=>$user->phone_number, 'date_of_birth'=>$user->date_of_birth, 'address'=>$user->address, 'town'=>$user->town, 'gender'=>$user->gender]);

        if ($update) {
            return response([
                "message" => "Profile successfully updated"
            ], 200);
        }else{
            return responder()->error(404, 'Patient ID not found!')->respond(404);
        }
    }
}
