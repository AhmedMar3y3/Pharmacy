<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Contract;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function dashboard()
    {
        $patientCount = Patient::count();
        $invoice = Invoice::count();
        $contract = Contract::count();
        return view('dashboard', compact('patientCount', 'invoice', 'contract'));
    }
}
