<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Medication;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceController extends Controller
{

    public function index()
    {
        $patients = Patient::all();
        $medications = Medication::all();
        $invoices = Invoice::paginate(15);
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

    //TODO: add type to invoice items
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date'       => 'required|date',
            'serial'     => 'required|string',
            'items'      => 'required|array|min:1',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.type'          => 'required|in:local,imported', // New validation rule for type
        ]);
    
        // Create the invoice with an initial total_support of 0
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
    
            if ($item['type'] === 'local') {
                $discountPercentage = $contract->local_discount_percentage;
            } else if ($item['type'] === 'imported') {
                $discountPercentage = $contract->imported_discount_percentage;
            }

    
            $supportedPrice = $medication->price * ((100 - $discountPercentage) / 100);
    
            $invoiceItem = InvoiceItems::create([
                'invoice_id'       => $invoice->id,
                'medication_id'    => $item['medication_id'],
                'quantity'         => $item['quantity'],
                'price'            => $medication->price,
                'type'             => $item['type'],
                'supported_price'  => $supportedPrice
            ]);
    
            $totalSupport += $invoiceItem->supported_price * $invoiceItem->quantity;
        }
    
        $invoice->update(['total_support' => $totalSupport]);
    
        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
    }
    


    public function download(Invoice $invoice)
    {
        $invoice->load(['patient', 'items.medication']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download("invoice-{$invoice->id}.pdf");
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['patient', 'items.medication']);
        return view('invoices.print', compact('invoice'));
    }

}
