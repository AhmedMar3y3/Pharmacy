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
        $search = request()->input('query');
    
        $query = Patient::query();
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ID_number', 'like', "%{$search}%");
            });
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
