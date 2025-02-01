<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "patient_id",
        "date",
        "total_support",
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function items(){
        return $this->hasMany(InvoiceItems::class);
    }

}