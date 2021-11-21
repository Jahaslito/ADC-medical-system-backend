<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    // Vital Signs
    public function vitals(Request $request) {
        $fields = $request->validate([
            'blood_pressure' => 'required',
            'temperature'=> 'required',
            'weight' => 'required',
            'height' => 'required'
        ]);

        return response($fields, 200);
    }
}
