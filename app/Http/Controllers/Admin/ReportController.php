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

        foreach ($patients as $patient) {
            $invoices = $patient->invoices()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();

            $totalInvoicePrice = 0;
            $totalSupportedPrice = 0;

            foreach ($invoices as $invoice) {
                $invoiceTotal = $invoice->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
                $totalInvoicePrice += $invoiceTotal;

                $totalSupportedPrice += $invoice->total_support;
            }

            $patientReports[] = [
                'patient' => $patient,
                'total_invoice_price' => $totalInvoicePrice,
                'total_supported_price' => $totalSupportedPrice,
            ];

            $grandTotalInvoicePrice += $totalInvoicePrice;
            $grandTotalSupportedPrice += $totalSupportedPrice;
        }

        return view('reports.show', compact(
            'contract',
            'monthParam',
            'patientReports',
            'grandTotalInvoicePrice',
            'grandTotalSupportedPrice'
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
        $grandTotalInvoicePrice = 0;
        $grandTotalSupportedPrice = 0;

        foreach ($patients as $patient) {
            $invoices = $patient->invoices()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();

            $totalInvoicePrice = 0;
            $totalSupportedPrice = 0;

            foreach ($invoices as $invoice) {
                $invoiceTotal = $invoice->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
                $totalInvoicePrice += $invoiceTotal;
                $totalSupportedPrice += $invoice->total_support;
            }

            $patientReports[] = [
                'patient' => $patient,
                'total_invoice_price' => $totalInvoicePrice,
                'total_supported_price' => $totalSupportedPrice,
            ];

            $grandTotalInvoicePrice += $totalInvoicePrice;
            $grandTotalSupportedPrice += $totalSupportedPrice;
        }

        return view('reports.print', compact(
            'contract',
            'monthParam',
            'patientReports',
            'grandTotalInvoicePrice',
            'grandTotalSupportedPrice'
        ));
    }
}
