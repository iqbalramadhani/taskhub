<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/task',[TaskController::class, 'index'])->name('tasks.index');
    Route::resource('project.task', TaskController::class)->except(['index','show']);

    Route::patch('task/{task}/toggle',[TaskController::class, 'toggle'])->name('tasks.toggle');
});

require __DIR__.'/auth.php';
