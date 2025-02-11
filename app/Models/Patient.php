<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'ID_number',
        'phone',
        'worker_num',
        'contract_id',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class,'contract_id');
    }
}
