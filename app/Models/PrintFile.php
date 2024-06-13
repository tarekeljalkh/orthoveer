<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintFile extends Model
{
    use HasFactory;


    protected $fillable = ['file_path'];

    public function scans()
    {
        return $this->belongsToMany(Scan::class, 'print_file_scan');
    }


}
