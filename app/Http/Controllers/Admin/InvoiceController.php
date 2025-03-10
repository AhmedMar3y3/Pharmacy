<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\InvoiceItems;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{

    public function index()
    {
        $patients = Patient::all();
        $medications = Medication::all();
        $invoices = Invoice::paginate(15);
        return view('invoices.index', compact('invoices', 'medications', 'patients'));
    }
    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'items.medication']);
        return view('invoices.show', compact('invoice'));
    }
    
        public function create()
        {
            $patients = Patient::all();
            $medications = Medication::all();
            return view('invoices.index', compact('patients', 'medications'));
        }


        public function store(Request $request)
        {
            $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'date'       => 'required|date',
                'serial'     => 'required|string',
                'items'      => 'required|array|min:1',
                'items.*.medication_id' => 'required|exists:medications,id',
                'items.*.quantity'      => 'required|numeric|min:0.01',
                'items.*.type'          => 'required|in:local,imported',
                'items.*.price'         => 'required|numeric|min:0',
            ]);
        
            $invoice = Invoice::create([
                'patient_id'    => $request->patient_id,
                'date'          => $request->date,
                'serial'        => $request->serial,
                'total_support' => 0
            ]);
        
            $totalSupport = 0;
            $patient  = Patient::findOrFail($request->patient_id);
            $contract = $patient->contract;
        
            foreach ($request->items as $item) {
                $medication = Medication::findOrFail($item['medication_id']);
        
                if ($medication->price != $item['price']) {
                    $medication->update(['price' => $item['price']]);
                }
        
                if ($item['type'] === 'local') {
                    $discountPercentage = $contract->local_discount_percentage;
                } elseif ($item['type'] === 'imported') {
                    $discountPercentage = $contract->imported_discount_percentage;
                }
        
                $supportedPrice = $medication->price * ((100 - $discountPercentage) / 100);
        
                $invoiceItem = InvoiceItems::create([
                    'invoice_id'      => $invoice->id,
                    'medication_id'   => $item['medication_id'],
                    'quantity'        => $item['quantity'],
                    'price'           => $medication->price,
                    'type'            => $item['type'],
                    'supported_price' => $supportedPrice
                ]);
        
                $totalSupport += $invoiceItem->supported_price * $invoiceItem->quantity;
            }
        
            $invoice->update(['total_support' => $totalSupport]);
        
            return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
        }


        public function update(Request $request, Invoice $invoice)
{
    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'date' => 'required|date',
        'serial' => 'required|string',
        'items' => 'required|array|min:1',
        'items.*.medication_id' => 'required|exists:medications,id',
        'items.*.quantity' => 'required|numeric|min:0.01',
        'items.*.type' => 'required|in:local,imported',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    $invoice->update([
        'patient_id' => $request->patient_id,
        'date' => $request->date,
        'serial' => $request->serial,
    ]);

    $invoice->items()->delete(); // Delete existing items

    $totalSupport = 0;
    $patient = Patient::findOrFail($request->patient_id);
    $contract = $patient->contract;

    foreach ($request->items as $item) {
        $medication = Medication::findOrFail($item['medication_id']);
        if ($medication->price != $item['price']) {
            $medication->update(['price' => $item['price']]);
        }

        $discountPercentage = $item['type'] === 'local' ? $contract->local_discount_percentage : $contract->imported_discount_percentage;
        $supportedPrice = $medication->price * ((100 - $discountPercentage) / 100);

        $invoiceItem = InvoiceItems::create([
            'invoice_id' => $invoice->id,
            'medication_id' => $item['medication_id'],
            'quantity' => $item['quantity'],
            'price' => $medication->price,
            'type' => $item['type'],
            'supported_price' => $supportedPrice
        ]);

        $totalSupport += $invoiceItem->supported_price * $invoiceItem->quantity;
    }

    $invoice->update(['total_support' => $totalSupport]);

    return redirect()->route('invoices.index')->with('success', 'تم تعديل الفاتورة بنجاح');
}


public function destroy(Invoice $invoice)
{
    $invoice->delete();
    return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح');
}
        


    public function print(Invoice $invoice)
    {
        $invoice->load(['patient', 'items.medication']);
        return view('invoices.print', compact('invoice'));
    }
}
