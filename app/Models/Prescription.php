<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Prescription extends Model
{
    use HasFactory, hasApiTokens;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'prescription_id',
        'name',
        'quantity',
        'diagnosis_id',
        'dosage'
    ];

    public function diagnosis() {
    	return $this->hasMany(Diagnosis::class);
    }
}
