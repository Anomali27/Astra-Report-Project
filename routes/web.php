<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// HALAMAN UTAMA
Route::get('/', function () {
    return view('welcome');
});

// AUTHENTICATION
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])
        ->name('login-view');

    Route::post('/login', [AuthController::class, 'loginPost'])
        ->name('login-post');

    Route::get('/register', [AuthController::class, 'registerView'])
        ->name('register-view');

    Route::post('/register', [AuthController::class, 'registerPost'])
        ->name('register-post');
});

// ROUTE YANG MEMERLUKAN LOGIN
Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // TASKS
    Route::resource('tasks', TaskController::class)
        ->middlewareFor(
            ['index', 'show'],
            'role:supervisor,dealer'
        )
        ->middlewareFor(
            ['create', 'store', 'edit', 'update', 'destroy'],
            'role:supervisor'
        );

    // REVIEW TASK - SUPERVISOR
    Route::get('/tasks/{task}/review', [TaskController::class, 'review'])
        ->middleware('role:supervisor')
        ->name('tasks.review');

    Route::post(
        '/tasks/{task}/review/{submission}',
        [TaskController::class, 'reviewSubmission']
    )
        ->middleware('role:supervisor')
        ->name('tasks.review.store');

    // SUBMIT TASK - DEALER
    Route::get('/tasks/{task}/submit', [TaskController::class, 'submit'])
        ->middleware('role:dealer')
        ->name('tasks.submit');

    Route::post('/tasks/{task}/submit', [TaskController::class, 'storeSubmission'])
        ->middleware('role:dealer')
        ->name('tasks.submit.store');

    // DEALERS
    Route::resource('dealers', DealerController::class)
        ->middlewareFor(
            ['index', 'show'],
            'role:supervisor,dealer'
        )
        ->middlewareFor(
            ['create', 'store', 'edit', 'update', 'destroy'],
            'role:supervisor'
        );

    // AREAS - SUPERVISOR ONLY
    Route::resource('areas', AreaController::class)
        ->middlewareFor(
            ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'],
            'role:supervisor'
        );

    // DEPARTMENTS - SUPERVISOR ONLY
    Route::resource('departments', DepartmentController::class)
        ->middlewareFor(
            ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'],
            'role:supervisor'
        );
});
