<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'local_discount_percentage',
        'imported_discount_percentage',
    ];
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
