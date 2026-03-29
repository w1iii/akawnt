<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkawntController;

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

// Redirect root to home
Route::get('/', function () {
    return redirect('/home');
});

// Pages
Route::get('/home', [AkawntController::class, 'home']);
Route::get('/affiliates', [AkawntController::class, 'affiliates']);
Route::get('/reports', [AkawntController::class, 'reports']);
