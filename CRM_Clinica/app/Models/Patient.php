<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'lastName',
        'birth_date',
        'gender',
        'medical_history',
        'medical_history_file', 
        'parent1_name',
        'parent1_lastName',
        'parent1_phone',
        'parent1_email',
        'parent1_relationship',
        'parent2_name',
        'parent2_lastName',
        'parent2_phone',
        'parent2_email',
        'parent2_relationship',
        'address',
        'phone',
        'email',
        'school_id',
    ];
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeMedicalHistoryFile($file)
    {
        $path = $file->store('patients/medical_histories', 'public'); //ruta para guardar los pdfs

        $this->medical_history_file = $path;
        $this->save();
    }
}
