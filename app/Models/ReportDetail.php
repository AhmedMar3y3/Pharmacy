<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "report_id",
        "patient_id",
        "medication_id",
        "quantity",
        "support_amount",
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
