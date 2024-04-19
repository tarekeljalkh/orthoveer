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

    public function typeofwork()
    {
        return $this->belongsTo(TypeofWork::class, 'type_id');
    }

    /**
     * Get the notifications for the scan.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'scan_id');
    }


    public function status()
    {
        return $this->hasMany(Status::class);
    }


    public function getCurrentStatusAttribute()
    {
        // Assuming 'status' is the relationship name for all related status updates
        return $this->status()->latest('created_at')->first()->status ?? 'pending';
    }

    public function latestStatus()
    {
        return $this->hasOne(Status::class)->latestOfMany();
    }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_scans');
    // }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_scans')
            ->using(OrderScan::class); // Specifies to use OrderScan pivot model
    }
}
