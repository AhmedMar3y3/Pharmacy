<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
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
