<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\ServerStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/upload-image', [ImageController::class, 'uploadImage']);

Route::get('/v1/events', [EventController::class, 'ReturnEvents']);
Route::get('/v1/event/visitCount/{event_id}', [EventController::class, 'getAttendeesCount']);
Route::get('/v1/event/{event_id}', [EventController::class, 'ReturnEvent']);
Route::get('/v1/event/check/{event_id}/{user_id}', [EventController::class, 'checkUserAttendance']);
Route::post('/v1/event/attend', [EventController::class, 'attendEvent']);
Route::post('/v1/event/unattend', [EventController::class, 'unattendEvent']);

Route::get('/v1/ads', [AdController::class, 'ReturnAds']);

Route::post('/v1/meeting/create', [MeetController::class, 'CreateMeeting']);
Route::get('/v1/meetings',[MeetController::class, 'ReturnMeetings']);

Route::get('/STATUS', [ServerStatusController::class, 'ServerStatus']);

