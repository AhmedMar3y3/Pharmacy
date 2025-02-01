<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\medication\StoreMedicationRequest;
use App\Http\Requests\medication\UpdateMedicationRequest;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::all();
        return view('medications.index', compact('medications'));
    }

    public function show($id){
        $medication = Medication::find($id);
        return response()->json($medication);
    }

    public function store(StoreMedicationRequest $request)
    {
        Medication::create($request->validated());
        return redirect()->route('medications.index')->with('success', 'تم اضافة الدواء بنجاح');
    }

    public function update(UpdateMedicationRequest $request, $id)
    {
        $medication = Medication::find($id);
        $medication->update($request->validated());
        return redirect()->route('medications.index')->with('success', 'تم تعديل الدواء بنجاح');
    }

    public function destroy($id)
    {
        Medication::find($id)->delete();
        return redirect()->route('medications.index')->with('success', 'تم حذف الدواء بنجاح');
    }
}
