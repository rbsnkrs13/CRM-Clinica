<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_course_id',
        'user_id',
        'registration_date',
        'status',
        'amount_paid',
        'payment_status',
        'payment_method',
        'payment_date',
    ];

    public function trainingCourse()
    {
        return $this->belongsTo(TrainingCourse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainingInvoice()
    {
        return $this->hasOne(TrainingInvoice::class, 'training_registration_id');
    }

    
}
