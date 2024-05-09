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
}
