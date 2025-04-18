<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'start_date_time',
        'end_date_time',
        'capacity',
        'location',
        'syllabus',
    ];
    
    public function trainingRegistrations()
    {
        return $this->hasMany(TrainingRegistration::class);
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class, 'professional_training_course');
    }
}
