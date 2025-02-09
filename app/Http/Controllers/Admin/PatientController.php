<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StorePatientRequest;
use App\Http\Requests\patient\UpdatePatientRequest;
use App\Models\Patient;
use Carbon\Carbon;

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

        $clients = $query->get();
        return view('clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Patient::findOrFail($id);
        dd($client); 
        return view('clients.index', compact('client'));
    } 

    public function store(StorePatientRequest $request)
    {
        Patient::create($request->validated());
        return redirect()->route('clients.index')->with('success', 'تم اضافة العميل بنجاح');
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        $client = Patient::find($id);
        $client->update($request->validated());
        return redirect()->route('clients.index')->with('success', 'تم تعديل العميل بنجاح');
    }

    public function destroy($id)
    {
        Patient::find($id)->delete();
        return redirect()->route('clients.index')->with('success', 'تم حذف العميل بنجاح');
    }
}
