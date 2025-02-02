<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Medication;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{

    public function index()
    {
        $patients = Patient::all();
        $medications = Medication::all();
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices','medications','patients'));
    }
    public function show(Invoice $invoice)
    {
        // Eager load related patient and medication data
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
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);
    
        $invoice = Invoice::create([
            'patient_id' => $request->patient_id,
            'date' => $request->date,
            'total_support' => 0
        ]);
    
        $totalSupport = 0;
    
        foreach ($request->items as $item) {
            $medication = Medication::findOrFail($item['medication_id']);
            
            // Check stock availability
            if ($medication->quantity < $item['quantity']) {
                return back()->with('error', "Not enough stock for {$medication->name}");
            }
    
            // Update medication stock
            $medication->decrement('quantity', $item['quantity']);
    
            $invoiceItem = InvoiceItems::create([
                'invoice_id' => $invoice->id,
                'medication_id' => $item['medication_id'],
                'quantity' => $item['quantity'],
                'price' => $medication->price,
                'supported_price' => $medication->supported_price
            ]);
    
            $totalSupport += $invoiceItem->supported_price * $invoiceItem->quantity;
        }
    
        $invoice->update(['total_support' => $totalSupport]);
    
        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
    }


}
