<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'contact_person',
        'contact_person_phone',
        'contact_person_email',
        'notes',
    ];
    /**
     * Get the patients associated with the school.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    public function patients()
    {
        return $this->hasMany(Patient::class, 'school_id');
    }
}
