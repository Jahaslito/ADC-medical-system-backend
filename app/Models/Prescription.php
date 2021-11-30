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
        'dosage'
    ];

    public function diagnosis() {
    	return $this->belongsToMany(Diagnosis::class);
    }
}
