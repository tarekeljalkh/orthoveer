<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = ['lab_id', 'dhl_tracking_number', 'status', 'origin', 'destination'];


    // public function scans()
    // {
    //     return $this->belongsToMany(Scan::class, 'order_scans');
    // }


    public function scans()
    {
        return $this->belongsToMany(Scan::class, 'order_scans')
            ->using(OrderScan::class); // Specifies to use OrderScan pivot model
    }

    //order relation for order maker which is basically the lab
    public function lab()
    {
        return $this->belongsTo(User::class, 'lab_id');
    }

}
