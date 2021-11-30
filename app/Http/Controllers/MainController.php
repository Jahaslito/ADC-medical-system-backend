<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VitalSigns;

class MainController extends Controller
{
    // Vital Signs
    public function vitals(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'weight' => 'required',
            'blood_pressure' => 'required',
            'height' => 'required',
            'pulse_rate' => 'required',
            
            'lab_test_id' => 'required',
            'staff_id' => 'required'
        ]);

        $weight = $fields['weight'];
        $height = $fields['height'];

        $BMI = $weight / ($height*$height);

        $vitalsign = VitalSigns::create([
            'patient_id' => $fields['patient_id'],
            'weight' => $fields['weight'],
            'blood_pressure' => $fields['blood_pressure'],
            'height' => $fields['height'],
            'pulse_rate' => $fields['pulse_rate'],
            'BMI' => $BMI,
            'lab_test_id' => $fields['lab_test_id'],
            'staff_id' => $fields['staff_id']
        ]);

        if ($vitalsign) {
            return response([
                "message" => "Patient records have been successfully inserted"
            ], 200);
        } else {
             return response([
                "message" => "There was an error inserting the patient records!!Please try again"
            ], 401);
        }
    }
}
