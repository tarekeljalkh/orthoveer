<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeofWork extends Model
{
    use HasFactory;

    public function lab()
    {
        return $this->belongsTo(User::class, 'lab_id');
    }

    public function secondLab()
    {
        return $this->belongsTo(User::class, 'second_lab_id');
    }

    public function externalLab()
    {
        return $this->belongsTo(User::class, 'external_lab_id');
    }

    public function doctorPrices()
    {
        return $this->hasMany(DoctorWorkPrice::class, 'type_of_work_id');
    }

    public function getPriceWithTvaAttribute()
    {
        $price = $this->lab_price;
        $tva = $this->vat;

        if ($price !== null && $tva !== null) {
            return $price + ($price * $tva / 100);
        }

        return $price; // If TVA is not defined, return the price without TVA
    }
}
