<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class LabResult extends Model
{
    use HasFactory, hasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lab_test_id',
        'patient_id',
        'results',
        'test_type',
        'result_type_id'
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function labresulttype() {
    	return $this->hasMany(LabResultType::class);
    }

    public function vitalsigns() {
    	$return $this->belongsTo(VitalSigns::class);
    }
}
