<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MedicationImportController;



Route::post('/register',[AuthController::class, 'register']); 

Route::post('/import-medications', [MedicationImportController::class, 'import']);