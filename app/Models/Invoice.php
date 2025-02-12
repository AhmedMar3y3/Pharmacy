<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "patient_id",
        "date",
        "total_support",
        "serial",
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }
}
