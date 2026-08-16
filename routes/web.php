<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LicenseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('licenses.index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('portal.auth')->group(function () {
    Route::resource('licenses', LicenseController::class)->except(['show']);
});
