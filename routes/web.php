<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login-post');

Route::get('/register', [AuthController::class, 'registerView'])->name('register-view');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register-post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('dealers', DealerController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('areas', AreaController::class);
Route::resource('tasks', TaskController::class);

Route::get('/tasks/{id}/review', [TaskController::class, 'review'])->name('tasks.review');
Route::get('/tasks/{id}/submit',[TaskController::class, 'submit'])->name('tasks.submit');
