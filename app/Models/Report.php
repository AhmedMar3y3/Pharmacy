<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
       'date',
       'total_support',
    ];

    public function reportDetails()
    {
        return $this->hasMany(ReportDetail::class);
    }
}
