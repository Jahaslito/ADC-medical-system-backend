<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\VitalSigns;
use App\Models\Diagnosis;
use App\Models\Symptoms;
use App\Models\LabResult;
use App\Models\LabResultType;
use App\Models\Prescription;

class MainController extends Controller
{
    // Vital Signs
    public function vitals(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
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
            'temperature' => $fields['temperature'],
            'blood_pressure' => $fields['blood_pressure'],
            'height' => $fields['height'],
            'pulse_rate' => $fields['pulse_rate'],
            'BMI' => $BMI,
            'lab_test_id' => $fields['lab_test_id'],
            'staff_id' => $fields['staff_id']
        ]);

        if ($vitalsign) {
            return responder()->success($vitalsign)->meta(["message" => "Patient's vitals have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the patient's vitals!!!Please try again")->respond(404);
        }
    }

    // Update Vital Signs
    public function update_vitals(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'weight' => 'required',
            'blood_pressure' => 'required',
            'temperature' => 'required',
            'height' => 'required',
            'pulse_rate' => 'required',
            'lab_test_id' => 'required',
            'staff_id' => 'required'
        ]);
        
        $weight = $fields['weight'];
        $height = $fields['height'];

        $BMI = $weight / ($height*$height);

        $updated_vitals = DB::table('vital_signs')
                                ->where('patient_id', $fields['patient_id'])
                                ->update([
                                    'weight' => $fields['weight'],
                                    'blood_pressure' => $fields['blood_pressure'],
                                    'temperature' => $fields['temperature'],
                                    'height' => $fields['height'],
                                    'BMI' => $BMI,
                                    'pulse_rate' => $fields['pulse_rate'],
                                    'lab_test_id' => $fields['lab_test_id'],
                                ]);

        if ($updated_vitals) {
            return response([
                "message" => "Patient's vitals have been successfully updated"
            ], 200);
        } else {
            return responder()->error(404, "There was an error updating the patient's vitals. Please confirm the patient ID and try again!")->respond(404);  
        }
    }

    // Searching vitals for a particular patient
    public function search_vitals($patient_id) {
        $vital_signs = VitalSigns::where('patient_id', 'LIKE', '%' . $patient_id . '%')->get();

        if (count($vital_signs)) {
            return responder()->success($vital_signs->toArray())->meta(["message" => "Patient's vitals fetched successfully"]);
        } else {
            return responder()->error(404, 'Patient ID id not found!')->respond(404);
        }
    }

    // Fetching patient diagnosis
    public function fetch_diagnosis($patient_id) {
        $patient_diagnosis = Diagnosis::where('patient_id', 'LIKE', '%' . $patient_id . '%')->get();

        if (count($patient_diagnosis)) {
            return responder()->success($patient_diagnosis->toArray())->meta(["message" => "Patient's diagnoses fetched successfully"]);
        } else {
            return responder()->error(404, 'Patient ID id not found!')->respond(404);
        }
    }

    // This function inserts patient prescriptions
    public function insert_prescription(Request $request) {
        $fields = $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'dosage' => 'required'
        ]); 

        $prescription = Prescription::create([
            'name' => $fields['name'],
            'quantity' => $fields['quantity'],
            'dosage' => $fields['dosage']
        ]); 

        if ($prescription) {
            return response([
                "message" => "Patient Prescription inserted successfully"
            ], 200);
        } else {
            return responder()->error(404, "There was an error inserting the patient prescriptions!!!Please try again")->respond(404);  
        }
    }

    // This function fetches the prescription of a patient
    public function fetch_prescription($patient_id) {
        $pid = DB::table('diagnoses')
                    ->select('prescription_id')
                    ->where('patient_id', $patient_id)
                    ->orderBy('created_at', 'desc')
                    ->value('prescription_id');

        $prescription = Prescription::where('prescription_id', $pid)->get();

        if ($prescription) {
            return responder()->success($prescription)->meta(["message" => "Prescription fetched successfully"]);
        } else {
            return response([
                "message" => "There was an error fetching the prescription!!Please confirm the patient ID and try again"
            ], 404);
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
            return responder()->success($diagnoses)->meta(["message" => "Diagnosis records have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the diagnosis records!!!Please try again")->respond(404);  
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
            return responder()->success($symptom)->meta(["message" => "Patient's Symptoms have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the patient symptoms!!!Please try again")->respond(404);
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
            return responder()->success($result_type)->meta(["message" => "Result Type records have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the Result Type records!!!Please try again")->respond(404);  
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
            return responder()->success($lab_result)->meta(["message" => "Lab records have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the lab records!!!Please try again")->respond(404);  
        }
    }
}
