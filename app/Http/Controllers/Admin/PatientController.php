<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use App\Http\Controllers\Controller;
use App\Http\Requests\patient\StorePatientRequest;
use Illuminate\Http\Request;
use App\Models\Contract;
use Illuminate\Validation\Rule;


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

        $clients = $query->with('contract')->get();
        $contracts = Contract::all();
        return view('clients.index', compact('clients','contracts'));
    }


    public function show($id)
    {
        $client = Patient::findOrFail($id)->load('contract');
        return response()->json($client);
    }

    public function store(StorePatientRequest $request)
    {
        Patient::create($request->validated());
        $contracts = Contract::all();
        return redirect()->route('clients.index',compact('contracts'))->with('success', 'تم اضافة العميل بنجاح');
    }

    public function update(Request $request, $id)
    {
        // Adjust the unique rule for ID_number to ignore the current client
        $validatedData = $request->validate([
            "name"       => "nullable|string",
            "phone"      => "nullable|string",
            "worker_num" => "nullable|string",
            "contract_id"=> "nullable|exists:contracts,id",
            "ID_number"  => [
                "nullable",
                "string",
                Rule::unique('patients', 'ID_number')->ignore($id),
            ],
        ]);

        $client = Patient::findOrFail($id);
        $client->update($validatedData);
        return redirect()->route('clients.index')->with('success', 'تم تعديل العميل بنجاح');
    }

    public function destroy($id)
    {
        Patient::find($id)->delete();
        return redirect()->route('clients.index')->with('success', 'تم حذف العميل بنجاح');
    }
}
