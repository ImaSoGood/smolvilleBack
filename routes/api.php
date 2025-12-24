<?php

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
Route::get('/v1/eventVisit/{event_id}', [EventController::class, 'ReturnAttendeesCount']);
Route::get('/v1/event/{event_id}', [EventController::class, 'ReturnEvent']);

Route::get('/v1/meetings',[MeetController::class, 'ReturnMeetings']);

Route::get('/STATUS', [ServerStatusController::class, 'ServerStatus']);

