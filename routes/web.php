<?php

use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController;
use Illuminate\Support\Facades\Route;

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
Route::put('/update-medication', [MedicationController::class, 'update'])->name('medications.update');
Route::delete('/delete-medication', [MedicationController::class, 'destroy'])->name('medications.destroy');
