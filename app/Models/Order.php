<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'lab_id',
        'scan_id',
        'name',
        'street',
        'suburb',
        'postcode',
        'country',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function scans()
    {
        return $this->belongsToMany(Scan::class, 'order_scans')
                    ->using(OrderScan::class);
    }

    public function lab()
    {
        return $this->belongsTo(User::class, 'lab_id');
    }

}
