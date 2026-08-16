<?php

use App\Http\Controllers\LicenseVerificationController;
use Illuminate\Support\Facades\Route;

Route::post('/verify-license', [LicenseVerificationController::class, 'verify'])->name('api.verify-license');
