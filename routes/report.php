<?php

use App\Http\Controllers\ReportController;
use App\Models\DeviceLog;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/analytics', [ReportController::class, 'showAnalytics'])->middleware('role:creator')->name('analytics');

    Route::get('/contributions', function () {
        $donations = auth()->user()->donations()->paginate(6);
        return view('reporting.contributions', compact('donations'));
    })->middleware('role:backer')->name('contributions');

    Route::post('/report', [ReportController::class, 'storeReport']);
});