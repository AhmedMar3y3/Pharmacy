<?php

namespace App\Http\Controllers\Admin;

use App\Models\Medication;
use App\Http\Controllers\Controller;
use App\Http\Requests\medication\StoreMedicationRequest;
use App\Http\Requests\medication\UpdateMedicationRequest;

class MedicationController extends Controller
{
    public function index()
    {
        $search = (string) request('search');
        $medications = Medication::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(20);

        return view('medications.index', compact('medications'));
    }

    public function show($id)
    {
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
