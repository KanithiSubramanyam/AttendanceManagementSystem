<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('joinDates', App\Http\Controllers\JoinDateController::class);

Route::resource('joinDetails', App\Http\Controllers\JoinDetailController::class);

Route::resource('attendances', App\Http\Controllers\AttendanceController::class);
Route::resource('demos', App\Http\Controllers\demoController::class);