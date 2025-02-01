<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\AuthController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Route::post('/login',[AuthController::class,'loginHome'])->name('login');





Route::get('/login', [AuthController::class, 'loadLogin'])->name('login.page');

Route::post('/login-user', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('/register', [AuthController::class, 'registerHome'])->name('register.home');
// Route::post('/register', [AuthController::class, 'register'])->name('register');
