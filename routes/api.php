<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/employee/{id}', [EmployeeController::class, 'show']);
Route::put('/employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy']);
Route::get('/employee/search/{name}', [EmployeeController::class, 'search']);
Route::get('/employee/status/active', [EmployeeController::class, 'active']);
Route::get('/employee/status/active', [EmployeeController::class, 'inactive']);
Route::get('/employee/status/terminated', [EmployeeController::class, 'terminated']);


