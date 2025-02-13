<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function index()
    {
        $contracts = Contract::all();
        return view('reports.index', compact('contracts'));
    }

    public function show(Request $request, Contract $contract)
    {
        $monthParam = $request->query('month');
        if ($monthParam) {
            list($year, $month) = explode('-', $monthParam);
        } else {
            $year = date('Y');
            $month = date('m');
            $monthParam = $year . '-' . $month;
        }
    
        $patients = $contract->patients;
    
        $patientReports = [];
        $grandTotalInvoicePrice = 0;
        $grandTotalSupportedPrice = 0;
        $grandTotalLocalPrice   = 0;
        $grandTotalImportedPrice = 0;
    
        foreach ($patients as $patient) {
            $invoices = $patient->invoices()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
    
            $totalInvoicePrice   = 0;
            $totalSupportedPrice = 0;
            $totalLocalPrice     = 0;
            $totalImportedPrice  = 0;
    
            foreach ($invoices as $invoice) {
                // Calculate totals per invoice by medication type:
                $invoiceLocalTotal = $invoice->items
                    ->where('type', 'local')
                    ->sum(function ($item) {
                        return $item->price * $item->quantity;
                    });
                $invoiceImportedTotal = $invoice->items
                    ->where('type', 'imported')
                    ->sum(function ($item) {
                        return $item->price * $item->quantity;
                    });
    
                // Update the patient totals
                $totalLocalPrice    += $invoiceLocalTotal;
                $totalImportedPrice += $invoiceImportedTotal;
                $invoiceTotal = $invoiceLocalTotal + $invoiceImportedTotal;
                $totalInvoicePrice += $invoiceTotal;
    
                $totalSupportedPrice += $invoice->total_support;
            }
    
            // Save the report for this patient including the new totals:
            $patientReports[] = [
                'patient'               => $patient,
                'total_invoice_price'   => $totalInvoicePrice,
                'total_supported_price' => $totalSupportedPrice,
                'total_local_price'     => $totalLocalPrice,
                'total_imported_price'  => $totalImportedPrice,
            ];
    
            // Update the grand totals
            $grandTotalInvoicePrice   += $totalInvoicePrice;
            $grandTotalSupportedPrice += $totalSupportedPrice;
            $grandTotalLocalPrice     += $totalLocalPrice;
            $grandTotalImportedPrice  += $totalImportedPrice;
        }
    
        return view('reports.show', compact(
            'contract',
            'monthParam',
            'patientReports',
            'grandTotalInvoicePrice',
            'grandTotalSupportedPrice',
            'grandTotalLocalPrice',
            'grandTotalImportedPrice'
        ));
    }
    
    public function print(Request $request, Contract $contract)
    {
        $monthParam = $request->query('month');
        if ($monthParam) {
            list($year, $month) = explode('-', $monthParam);
        } else {
            $year = date('Y');
            $month = date('m');
            $monthParam = $year . '-' . $month;
        }
    
        $patients = $contract->patients;
        $patientReports = [];
        $grandTotalInvoicePrice   = 0;
        $grandTotalSupportedPrice = 0;
        $grandTotalLocalPrice     = 0;
        $grandTotalImportedPrice  = 0;
    
        foreach ($patients as $patient) {
            $invoices = $patient->invoices()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
    
            $totalInvoicePrice   = 0;
            $totalSupportedPrice = 0;
            $totalLocalPrice     = 0;
            $totalImportedPrice  = 0;
    
            foreach ($invoices as $invoice) {
                // Calculate totals per invoice by medication type:
                $invoiceLocalTotal = $invoice->items
                    ->where('type', 'local')
                    ->sum(function ($item) {
                        return $item->price * $item->quantity;
                    });
                $invoiceImportedTotal = $invoice->items
                    ->where('type', 'imported')
                    ->sum(function ($item) {
                        return $item->price * $item->quantity;
                    });
    
                $invoiceTotal = $invoiceLocalTotal + $invoiceImportedTotal;
                $totalInvoicePrice   += $invoiceTotal;
                $totalSupportedPrice += $invoice->total_support;
    
                $totalLocalPrice    += $invoiceLocalTotal;
                $totalImportedPrice += $invoiceImportedTotal;
            }
    
            $patientReports[] = [
                'patient'               => $patient,
                'total_invoice_price'   => $totalInvoicePrice,
                'total_supported_price' => $totalSupportedPrice,
                'total_local_price'     => $totalLocalPrice,
                'total_imported_price'  => $totalImportedPrice,
            ];
    
            $grandTotalInvoicePrice   += $totalInvoicePrice;
            $grandTotalSupportedPrice += $totalSupportedPrice;
            $grandTotalLocalPrice     += $totalLocalPrice;
            $grandTotalImportedPrice  += $totalImportedPrice;
        }
    
        return view('reports.print', compact(
            'contract',
            'monthParam',
            'patientReports',
            'grandTotalInvoicePrice',
            'grandTotalSupportedPrice',
            'grandTotalLocalPrice',
            'grandTotalImportedPrice'
        ));
    }
    
}
