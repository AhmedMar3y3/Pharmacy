<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Contract;


class HomeController extends Controller
{

    public function dashboard()
    {
        $lastWeekStart = now()->subWeek()->startOfWeek()->toDateTimeString(); //اخر اسبببوع
        $lastWeekEnd = now()->subWeek()->endOfWeek()->toDateTimeString();
        $patientCount = Patient::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $invoice=Invoice::count();

        $contract=Contract::count();


        return view('dashboard', compact('patientCount','invoice','contract'));
    }

    
    // $currentWeekStart = now()->startOfWeek()->toDateTimeString(); // االاسبوع الحالي
    // $currentWeekEnd = now()->endOfWeek()->toDateTimeString();    
    // $patientCount = Patient::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();

}
