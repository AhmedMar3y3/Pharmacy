<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\contract\StoreContractRequest;
use App\Http\Requests\contract\UpdateContractRequest;
use Illuminate\Http\Request;
use App\Models\Contract;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    public function store(StoreContractRequest $request)
    {
        Contract::create($request->validated());
        return redirect()->route('contracts.index')->with('success', 'تم اضافة العقد بنجاح');
    }

    public function update(UpdateContractRequest $request, $id)
    {
        $client = Contract::find($id);
        $client->update($request->validated());
        return redirect()->route('contracts.index')->with('success', 'تم تعديل العقد بنجاح');
    }

    public function destroy($id)
    {
        Contract::find($id)->delete();
        return redirect()->route('contracts.index')->with('success', 'تم حذف العقد بنجاح');
    }
}
