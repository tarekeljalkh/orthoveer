<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function lab()
    {
        return $this->belongsTo(User::class, 'lab_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function typeofwork()
    {
        return $this->belongsTo(TypeofWork::class, 'type_id');
    }

}
