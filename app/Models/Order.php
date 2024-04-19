<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // public function scans()
    // {
    //     return $this->belongsToMany(Scan::class, 'order_scans');
    // }

    public function scans()
    {
        return $this->belongsToMany(Scan::class, 'order_scans')
            ->using(OrderScan::class); // Specifies to use OrderScan pivot model
    }
}
