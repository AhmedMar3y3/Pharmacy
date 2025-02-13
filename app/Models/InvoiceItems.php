<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItems extends Model
{
    use HasFactory;
    protected $fillable = [
        "invoice_id",
        "medication_id",
        "quantity",
        "price",
        'type',
        "supported_price",
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
