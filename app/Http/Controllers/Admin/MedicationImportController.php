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
        // Validate file input
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        // Import the Excel file
        Excel::import(new MedicationsImport, $request->file('file'));

        return response()->json(['message' => 'Medications imported successfully.']);
    }
}
