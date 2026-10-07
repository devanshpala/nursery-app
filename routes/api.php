<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\NurseryController;
use App\Http\Controllers\Api\RoomAttendanceController;

Route::middleware(['tenant'])->group(function () {
    // Children CRUD
    Route::apiResource('children', ChildController::class);
    
    // Rooms CRUD
    Route::apiResource('rooms', RoomController::class);
    
    // Staff CRUD
    Route::apiResource('staff', StaffController::class);
    
    // Nurseries CRUD
    Route::apiResource('nurseries', NurseryController::class);
    
    // Room Attendance CRUD
    Route::apiResource('room-attendances', RoomAttendanceController::class);
    
    // Check a child into a room
    Route::post('/rooms/{room}/check-ins', [RoomAttendanceController::class, 'store']);
    
    // Check a child out of the room
    Route::post('/check-ins/{id}/check-out', [RoomAttendanceController::class, 'checkOut']);
    
    // List occupants currently in a room
    Route::get('/rooms/{room}/occupants', [RoomAttendanceController::class, 'occupants']);
});