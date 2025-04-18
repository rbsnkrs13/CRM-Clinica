<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'service_id',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}

