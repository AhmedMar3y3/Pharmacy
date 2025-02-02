<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ID_number',
        'phone',
        'address',
    ];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
