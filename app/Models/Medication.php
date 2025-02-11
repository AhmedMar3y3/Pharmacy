<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeAvailable($query, $quantity)
    {
        return $query->where('quantity', '>=', $quantity);
    }
}
