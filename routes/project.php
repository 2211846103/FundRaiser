<?php

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::resource('projects', ProjectController::class);

Route::middleware('role:creator')->group(function () {
    Route::get('/creator/projects', function () {
        $projects = Project::paginate(10);
        return view('project.my-projects', compact('projects'));
    })->name('my-projects');
});