<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'professional_id',
        'assessment_date',
        'title',
        'notes',
        'file_path',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
