<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TrainingInvoice extends Model
{  
    use HasFactory;

    protected $fillable = [
        'training_registration_id',
        'invoice_number',
        'billing_date',
        'total_amount',
        'amount_paid',
        'payment_status',
        'payment_method',
        'payment_date',
    ];

    public function trainingRegistration()
    {
        return $this->belongsTo(TrainingRegistration::class, 'training_registration_id');
    }
}
