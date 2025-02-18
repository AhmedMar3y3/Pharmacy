<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MedicationsImport;
use App\Http\Controllers\Controller;

class MedicationImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new MedicationsImport, $request->file('file'));

        return response()->json(['message' => 'Medications imported successfully.']);
    }
}
