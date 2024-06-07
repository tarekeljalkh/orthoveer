<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorWorkPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'type_of_work_id',
        'price'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function typeOfWork()
    {
        return $this->belongsTo(TypeOfWork::class, 'type_of_work_id');
    }

}
