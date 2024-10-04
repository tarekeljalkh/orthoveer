<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintFile extends Model
{
    use HasFactory;


    protected $fillable = ['file_path', 'scan_id'];

    public function scan()
    {
        return $this->belongsTo(Scan::class, 'scan_id');
    }



}
