<?php

namespace App\Imports;

use App\Models\Medication;
use Maatwebsite\Excel\Concerns\ToModel;

class MedicationsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Medication([
            'name'=>$row[2],
            'price'=>$row[7],
        ]);
    }
}
