<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('dealers', DealerController::class);
Route::resource('department', DepartmentController::class);
Route::resource('areas', AreaController::class);
Route::resource('assignments', AssignmentController::class);


