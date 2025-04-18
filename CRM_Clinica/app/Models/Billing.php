<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'professional_id',
        'appointment_id',
        'invoice_number',
        'billing_date',
        'due_date',
        'total_amount',
        'amount_paid',
        'payment_status',
        'payment_method',
        'payment_date',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'billing_id');
    }
}
