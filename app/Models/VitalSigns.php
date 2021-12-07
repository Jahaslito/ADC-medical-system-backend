<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class VitalSigns extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'weight',
        'temperature',
        'blood_pressure',
        'height',
        'pulse_rate',
        'BMI',
        'lab_test_id',
        'staff_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function labresult() {
        return $this->hasMany(LabResult::class);
    }

}
