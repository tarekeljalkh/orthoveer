<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'scan_id',
        'doctor_id',
        'second_lab_id',
        'notes',
        'uploaded_files',
        'external_stl_link',
        'status',
    ];

    public function scan()
    {
        return $this->belongsTo(\App\Models\Scan::class);
    }

    public function secondLab()
    {
        return $this->belongsTo(\App\Models\User::class, 'second_lab_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
