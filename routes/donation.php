<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::post('/donate', [DonationController::class, 'store'])->middleware('auth')->name('donate');