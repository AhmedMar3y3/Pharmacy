<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'supported_price',
        'quantity',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItems::class);
    }
}
