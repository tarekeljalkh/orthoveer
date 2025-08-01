<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $casts = [
        'dob' => 'date', // Ensure dob is cast to a date
    ];

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function lastScan()
    {
        return $this->hasOne(Scan::class)->latest();
    }

}
