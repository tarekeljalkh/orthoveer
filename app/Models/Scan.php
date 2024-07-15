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

    //protected $dates = ['due_date'];


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

    public function latestStatus()
    {
        return $this->hasOne(Status::class)->latestOfMany();
    }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_scans');
    // }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_scans')
    //         ->using(OrderScan::class); // Specifies to use OrderScan pivot model
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    // Relationship with print files
    public function printFiles()
    {
        return $this->belongsToMany(PrintFile::class, 'print_file_scan');
    }


    // Accessor for calculating the last due date
    public function getLastDueDateAttribute()
    {
        if ($this->typeofwork) {
            $labDueDate = $this->due_date->copy()->addDays($this->typeofwork->lab_due_date ?? 0);
            $secondLabDueDate = $this->due_date->copy()->addDays($this->typeofwork->second_lab_due_date ?? 0);
            $externalLabDueDate = $this->due_date->copy()->addDays($this->typeofwork->external_lab_due_date ?? 0);

            return max($labDueDate, $secondLabDueDate, $externalLabDueDate);
        }

        return $this->due_date;
    }


    public function getEffectivePriceAttribute()
    {
        $doctorPrice = DoctorWorkPrice::where('doctor_id', $this->doctor_id)
            ->where('type_of_work_id', $this->type_id)
            ->first();

        if ($doctorPrice) {
            return $doctorPrice->price;
        }

        return $this->typeofwork ? $this->typeofwork->lab_price : null;
    }
}
