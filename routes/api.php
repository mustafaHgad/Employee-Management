<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Departments
    Route::apiResource('departments', App\Http\Controllers\Api\DepartmentController::class);

    // Employees
    Route::apiResource('employees', App\Http\Controllers\Api\EmployeeController::class);

    // Exports
    Route::get('employees-export/csv', [App\Http\Controllers\Api\EmployeeController::class, 'exportCsv']);
    Route::get('employees-export/pdf', [App\Http\Controllers\Api\EmployeeController::class, 'exportPdf']);
});
