<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Route::get('employees', [EmployeeController::class, 'index']);
    // Route::post('employees', [EmployeeController::class, 'store']);
    // Route::get('employees/{id}', [EmployeeController::class, 'show']);
    // Route::put('employees/{id}', [EmployeeController::class, 'update']);
    // Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);
    Route::apiResource('/employees', EmployeeController::class);
});

