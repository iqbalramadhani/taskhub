<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // GET /projects → index() (daftar)
    // GET /projects/create → create() (form tambah)
    // POST /projects → store() (simpan baru)
    // GET /projects/{id} → show() (detail)
    // GET /projects/{id}/edit → edit() (form edit)
    // PUT /projects/{id} → update() (simpan perubahan)
    // DELETE /projects/{id} → destroy() (hapus)
    Route::resource('projects', ProjectController::class);

    // GET /projects/{id} → show() (detail)
    // GET /projects/{id}/tasks/create → create() (form tambah)
    // POST /projects/{id}/tasks → store() (simpan baru)
    // GET /projects/{id}/tasks/{id}/edit → edit() (form edit)
    // PUT /projects/{id}/tasks/{id} → update() (simpan perubahan)
    // DELETE /projects/{id}/tasks/{id} → destroy() (hapus)
    Route::resource('projects.tasks', TaskController::class)->except(['index', 'show']);

    Route::patch('task/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
});

require __DIR__ . '/auth.php';
