<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Scan;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'invoice_number',
        'total_amount',
        'status',
        'invoice_date',
        'due_date',
        'notes',
        'payment_method',
        'pdf_path',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}


    public function scans()
    {
        return $this->belongsToMany(Scan::class, 'invoice_scan')->withTimestamps();
        // If you defined a pivot model InvoiceScan and want to use it:
        // ->using(InvoiceScan::class)
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            $latestId = self::max('id') ? self::max('id') + 1 : 1;
            $year = now()->year;
            $invoice->invoice_number = 'INV-' . $year . '-' . str_pad($latestId, 5, '0', STR_PAD_LEFT);
        });
    }
}
