<?php

use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $projects = Project::withCount(['likedUsers' => function ($query) {
        $query->whereNotNull('project_id');
    }])
    ->whereIn('status', ['active', 'achieved'])
    ->orderBy('liked_users_count', 'desc')
    ->take(4)
    ->get();

    return view('index', compact('projects'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    })->middleware('role:admin')->name('admin');
});
Route::middleware('auth')->group(function () {
    Route::get('/creator', function () {
        return view('creator');
    })->middleware('role:creator')->name('creator');
});
Route::middleware('auth')->group(function () {
    Route::get('/backer', function () {
        $projects = Project::withCount(['likedUsers' => function ($query) {
            $query->whereNotNull('project_id');
        }])
        ->whereIn('status', ['active', 'achieved'])
        ->orderBy('liked_users_count', 'desc')
        ->take(4)
        ->get();

        return view('backer', compact('projects'));
    })->middleware('role:backer')->name('backer');
});

Route::get('/notifs', function () {
    $notifications = Notification::where('user_id', auth()->id())->paginate(5);
    return view('logging.notifications', compact('notifications'));
})->name('notifs');

Route::post('/notifications/{notification}/mark', [NotificationController::class, 'markRead'])->name('mark-read');
Route::post('/notifications/{notification}/clear', [NotificationController::class, 'clear'])->name('clear-notifs');
Route::post('/notifications/mark', [NotificationController::class, 'markAllRead'])->name('mark-all-read');
Route::post('/notifications/clear', [NotificationController::class, 'clearAll'])->name('clear-all-notifs');

require_once 'user.php';
require_once 'project.php';
require_once 'report.php';
require_once 'comment.php';
require_once 'donation.php';
require_once 'admin.php';