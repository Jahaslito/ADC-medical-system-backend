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
        'patient_id',
        'test_type',
        'lab_result_id'
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function labresulttype() {
    	return $this->hasMany(LabResultType::class);
    }

    public function vitalsigns() {
    	return $this->belongsTo(VitalSigns::class);
    }
}
