<?php

namespace App\Imports;

use App\Models\Medication;
use Maatwebsite\Excel\Concerns\ToModel;

class MedicationsImport implements ToModel
{
    /**
     * Map each row from the Excel file to the Medication model.
     */
    public function model(array $row)
    {
        return new Medication([
            'name'  => $row[1],
            'price' => $row[0],
        ]);
    }
}
