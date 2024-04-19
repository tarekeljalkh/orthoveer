<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderScan extends Pivot
{
    protected $table = 'order_scans'; // Ensure this matches your table name for the pivot

    public $incrementing = true; // If your pivot table has its own primary key

    protected $fillable = ['order_id', 'scan_id']; // Allow mass assignment

    // Define relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}
