<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('employees', App\Http\Controllers\API\EmployeeAPIController::class)
    ->except(['create', 'edit']);

Route::resource('join-dates', App\Http\Controllers\API\JoinDateAPIController::class)
    ->except(['create', 'edit']);



Route::resource('join-details', App\Http\Controllers\API\JoinDetailAPIController::class)
    ->except(['create', 'edit']);

Route::resource('attendances', App\Http\Controllers\API\AttendanceAPIController::class)
    ->except(['create', 'edit']);

Route::resource('demos', App\Http\Controllers\API\demoAPIController::class)
    ->except(['create', 'edit']);