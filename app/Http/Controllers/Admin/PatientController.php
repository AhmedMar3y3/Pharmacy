<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StorePatientRequest;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $query = Patient::query();

        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        if (request()->has('ID_number')) {
            $query->where('ID_number', 'like', '%' . request('ID_number') . '%');
        }

        $patients = $query->get();
        return view('patients.index', compact('patients'));
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        return response()->json($patient);
    }

    public function store(StorePatientRequest $request)
    {
        Patient::create($request->validated());
        return redirect()->route('patients.index')->with('success', 'تم اضافة العميل بنجاح');
    }

    public function update(StorePatientRequest $request, $id)
    {
        $patient = Patient::find($id);
        $patient->update($request->validated());
        return redirect()->route('patients.index')->with('success', 'تم تعديل العميل بنجاح');
    }

    public function destroy($id)
    {
        Patient::find($id)->delete();
        return redirect()->route('patients.index')->with('success', 'تم حذف العميل بنجاح');
    }
}
