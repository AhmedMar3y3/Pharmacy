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
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }
    public function show(Invoice $invoice)
    {
        $invoice->load('items.medication', 'patient');
        return view('invoices.show', compact('invoice'));
    }

    public function create()
    {
        $patients = Patient::all();
        $medications = Medication::all();
        return view('invoices.create', compact('patients', 'medications'));
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
            'total_support' => 0 // Temporary value
        ]);

        $totalSupport = 0;

        foreach ($request->items as $item) {
            $medication = Medication::find($item['medication_id']);

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

        return redirect()->route('invoices.show', $invoice);
    }
}
