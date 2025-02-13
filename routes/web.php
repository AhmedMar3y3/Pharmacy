<?php

use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;



// Public Routes
Route::get('/', [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin', [AuthController::class, 'loginUser'])->name('loginUser');

Route::middleware(['auth:sanctum'])->group(function () {


// Home Routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('dashboard');

// Medication Routes
Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');
Route::get('/medications/{id}', [MedicationController::class, 'show'])->name('medications.show');
Route::post('/store-medication', [MedicationController::class, 'store'])->name('medications.store');
Route::put('/update-medication/{id}', [MedicationController::class, 'update'])->name('medications.update');
Route::delete('/delete-medication/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');

// Invoice Routes
Route::get('/invoices', [InvoiceController::class,'index'])->name('invoices.index');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::post('/store-invoice', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices', [InvoiceController::class,'index'])->name('invoices.index');
Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');

// Client Routes
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

// Report Routes
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{contract}', [ReportController::class, 'show'])->name('reports.show');
Route::get('/reports/{contract}/print', [ReportController::class, 'print'])->name('reports.print');

//profile

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/{id}/check-password', [ProfileController::class, 'checkPassword'])->name('profile.checkPassword');

Route::get('/invoices/medications/search', [InvoiceController::class, 'searchMedications'])->name('invoices.medications.search');

});