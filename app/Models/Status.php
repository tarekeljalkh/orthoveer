<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['scan_id', 'status', 'note', 'updated_by'];


    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }

    // If you added a user relation for 'updated_by'
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
