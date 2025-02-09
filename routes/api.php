<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\Login\LoginController;
use \App\Http\Controllers\API\Attendance\AttendanceController;
use \App\Http\Controllers\API\Notifications\NotificationsController;
use App\Http\Controllers\API\PrivateEmployeeFiles\PrivateEmployeeFilesController;

Route::POST('Login',[LoginController::class,'login']);

Route::get('/attendance/{calculator_number}', [AttendanceController::class, 'getAttendance']);

Route::POST('Worker-Notifications',[NotificationsController::class,'WorkerNotifications']);
Route::POST('Worker-Unread-Notifications',[NotificationsController::class,'unreadNotifications']);
Route::POST('markAsRead',[NotificationsController::class,'markAsRead']);
Route::POST('markAsReadAll',[NotificationsController::class,'markAsReadAll']);

Route::POST('Private-Files',[PrivateEmployeeFilesController::class,'PrivateEmployeeFiles']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

});
