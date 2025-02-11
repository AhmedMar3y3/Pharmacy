<?php

use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/






Route::get('/', [AuthController::class, 'loadLogin'])->name('login.page');
Route::post('/login-user', [AuthController::class, 'login'])->name('login');
Route::middleware(['auth:sanctum'])->group(function () {
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('dashboard');
// Patient Routes
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::post('/store-patient', [PatientController::class, 'store'])->name('patients.store');
Route::put('/update-patient', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/delete-patient', [PatientController::class, 'destroy'])->name('patients.destroy');

// Medication Routes
Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');
Route::get('/medications/{id}', [MedicationController::class, 'show'])->name('medications.show');
Route::post('/store-medication', [MedicationController::class, 'store'])->name('medications.store');
Route::put('/update-medication/{id}', [MedicationController::class, 'update'])->name('medications.update');
Route::delete('/delete-medication/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');
//excelMedication
Route::post('/medication/import', [MedicationController::class, 'import'])->name('medications.import');


// Invoice Routes
Route::get('/invoices', [InvoiceController::class,'index'])->name('invoices.index');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::post('/store-invoice', [InvoiceController::class, 'store'])->name('invoices.store');
Route::put('/update-invoice/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
Route::get('/invoices', [InvoiceController::class,'index'])->name('invoices.index');
Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');


//clients
Route::get('/clients', [PatientController::class, 'index'])->name('clients.index');
Route::post('/store-clients', [PatientController::class, 'store'])->name('clients.store');
Route::put('/update-clients/{id}', [PatientController::class, 'update'])->name('clients.update');
Route::delete('/delete-clients/{id}', [PatientController::class, 'destroy'])->name('clients.destroy');

Route::get('/client/{id}', [PatientController::class, 'show'])->name('clients.show');

// Contract Routes
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
Route::put('/update-contract/{id}', [ContractController::class, 'update'])->name('contracts.update');
Route::delete('/delete-contract/{id}', [ContractController::class, 'destroy'])->name('contracts.destroy');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{contract}', [ReportController::class, 'show'])->name('reports.show');
Route::get('/reports/{contract}/print', [ReportController::class, 'print'])->name('reports.print');


});