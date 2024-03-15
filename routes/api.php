<?php

use App\Http\Controllers\ReportUser\ReportController;
use App\Http\Controllers\Devices\DeviceController;
use App\Http\Controllers\User\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Authentication
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/verify-otp', [AuthController::class, 'VerifyOTP'])->name('verifyOtp');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/get-otp', [AuthController::class, 'getOtp'])->name('getOtp');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');




Route::group(['middleware' => 'auth:sanctum'], function () {

// Profile
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');

// Report
Route::post('/report', [ReportController::class, 'report'])->name('report');
Route::get('/report-history', [ReportController::class, 'reportHistory'])->name('reportHistory');
Route::get('{reprtId}/single-report', [ReportController::class, 'singleReport'])->name('singleReport');

// Devices
Route::get('/list-devices', [DeviceController::class, 'listDevices'])->name('listDevices');
Route::post('/add-device', [DeviceController::class, 'addDevice'])->name('addDevice');
Route::get('/my-devices', [DeviceController::class, 'userDevices'])->name('userDevices');




    
});