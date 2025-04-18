<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professional extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'specialization',
        'phone',
        'email',
        'availability',
        'address',
        'biography',
    ];
    
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'professional_service');
    }

    public function trainingCourses()
    {
        return $this->belongsToMany(TrainingCourse::class, 'professional_training_course');
    }

    public function patientAssessments()
    {
        return $this->hasMany(PatientAssessment::class);
    }
}
