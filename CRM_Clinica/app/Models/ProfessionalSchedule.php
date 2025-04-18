<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfessionalSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'start_time',
        'end_time',
        'day_of_week',
        'date',
        'is_available',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
