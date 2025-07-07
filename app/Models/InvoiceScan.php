<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InvoiceScan extends Pivot
{
    use HasFactory;

    protected $table = 'invoice_scan';

    // If you want, define relationships back to Invoice and Scan:

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}
