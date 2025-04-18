<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class, 'professional_service');
    }
}
