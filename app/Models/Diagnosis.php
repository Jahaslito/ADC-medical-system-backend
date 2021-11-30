<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Diagnosis extends Model
{
    use HasFactory, hasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'staff_id',
        'patient_id',
        'diagnosis',
        'prescription_id'
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function prescription() {
    	return $this->belongsToMany(Prescription::class);
    }
}
