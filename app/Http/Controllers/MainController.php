<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\VitalSigns;
use App\Models\Diagnosis;
use App\Models\Symptoms;
use App\Models\LabResult;
use App\Models\LabResultType;

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

    // Update Vital Signs
    public function update_vitals(Request $request) {
        $this->validate($request, [
            'patient_id' => 'required',
            'weight',
            'blood_pressure',
            'height',
            'pulse_rate',
            'lab_test_id',
            'staff_id' => 'required'
        ]);

        $vitals = new VitalSigns;

        $pat_id = $request->get('patient_id');
        $staffId = $request->get('staff_id');

        if ($request->has('weight')) {
            $vitals->weight = $request->get('weight');
        }

        if ($request->has('blood_pressure')) {
            $vitals->blood_pressure = $request->get('blood_pressure');
        }

        if ($request->has('height')) {
            $vitals->height = $request->get('height');
        }

        if ($request->has('pulse_rate')) {
            $vitals->pulse_rate = $request->get('pulse_rate');
        }

        if ($request->has('lab_test_id')) {
            $vitals->lab_test_id = $request->get('lab_test_id');
        }

        $updated_vitals = DB::table('vital_signs')
                                ->where('patient_id', $pat_id)
                                ->update([
                                    'weight' => $vitals['weight'],
                                    'blood_pressure' => $vitals['blood_pressure'],
                                    'height' => $vitals['height'],
                                    'pulse_rate' => $vitals['pulse_rate'],
                                    'lab_test_id' => $vitals['lab_test_id'],
                                ]);

        if ($updated_vitals) {
             return response([
                "message" => "Vitals updated successfully"
            ], 200);
        } else {
            return response([
                "message" => "There was an error updating the vitals records!!Please try again"
            ], 401);    
        }
    }

    // Inputting diagnosis
    public function diagnosis(Request $request) {
        $fields = $request->validate([
            'staff_id' =>'required',
            'patient_id' => 'required',
            'diagnosis' => 'required',
            'prescription_id' => 'required'
        ]);

        $diagnoses = Diagnosis::create([
            'staff_id' => $fields['staff_id'],
            'patient_id' => $fields['patient_id'],
            'diagnosis' => $fields['diagnosis'],
            'prescription_id' => $fields['prescription_id']
        ]);

        if ($diagnoses) {
            return response([
                "message" => "Diagnosis records have been successfully inserted"
            ], 200);
        } else{
            return response([
                "message" => "There was an error inserting the diagnosis records!!Please try again"
            ], 401);
        }
    }

    // Inputting symptoms
    public function symptoms(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'description' => 'required'
        ]);

        $symptom = Symptoms::create([
            'patient_id' => $fields['patient_id'],
            'description' => $fields['description']
        ]);

        if ($symptom) {
            return response([
                "message" => "Patient's Symptoms have been successfully inserted"
            ], 200);
        } else{
            return response([
                "message" => "There was an error inserting the patient symptoms!!Please try again"
            ], 401);
        }
    }

    // Inputting the lab result type
    public function lab_result_type(Request $request) {
        $fields = $request->validate([
            'lab_result_name' => 'required',
            'patient_id' =>'required',
            'unit' => 'required'
        ]);

        $result_type = LabResultType::create([
            'patient_id' => $fields['patient_id'],
            'lab_result_name' => $fields['lab_result_name'],
            'unit' => $fields['unit']
        ]);

        if ($result_type) {
            return response([
                "message" => "Result Type records have been successfully inserted"
            ], 200);
        } else{
            return response([
                "message" => "There was an error inserting the Result Type records!!Please try again"
            ], 401);
        }
    }

    // Inputting the lab result
    public function lab_results(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'test_type' => 'required',
            'result_type_id' => 'required'
        ]);

        $res_type_id = DB::table('lab_result_types')
                                ->select('lab_result_id')
                                ->where('patient_id', $fields['patient_id'])
                                ->latest('created_at')
                                ->value('lab_result_id')
                                ->first();

        $lab_result = LabResult::create([
            'patient_id' => $fields['patient_id'],
            'test_type' => $fields['test_type'],
            'result_type_id' => $res_type_id
        ]);

        if ($lab_result) {
            return response([
                "message" => "Lab records have been successfully inserted"
            ], 200);
        } else{
            return response([
                "message" => "There was an error inserting the lab records!!Please try again"
            ], 401);
        }
    }
}
