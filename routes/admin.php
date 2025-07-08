<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Models\AdminLog;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->middleware('role:admin')->group(function () {
    Route::post('/admin/create', [AuthController::class, 'registerAdmin'])->name('register-admin');
    Route::post('/projects/{project}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::post('/projects/{project}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::post('/users/{user}/suspend', [AdminController::class, 'suspend'])->name('suspend');
    Route::post('/users/{user}/unsuspend', [AdminController::class, 'unsuspend'])->name('unsuspend');
    Route::post('/reports/{report}/deactivate', [AdminController::class, 'deactivate'])->name('deactivate');
    Route::post('/reports/{report}/resolve', [AdminController::class, 'resolve'])->name('resolve');

    Route::get('/admin/create', function () {
        $admins = User::where('role', 'admin')->get();
        return view('admin.create', compact('admins'));
    })->name('create-admin');
    Route::get('/review-projects', function () {
        $projects = Project::where('status', 'pending')->paginate(3);
        return view('admin.projects', compact('projects'));
    })->name('review-projects');
    Route::get('/manage-users', function () {
        $users = User::paginate(5);
        return view('admin.users', compact('users'));
    })->name('manage-users');
    Route::get('/handle-reports', function () {
        $reports = Report::paginate(4);
        return view('admin.reports', compact('reports'));
    })->name('handle-reports');
    Route::get('/activity-logs', function () {
        $logs = AdminLog::latest()->paginate(10);
        return view('admin.logs', compact('logs'));
    })->name('activity-logs');
});