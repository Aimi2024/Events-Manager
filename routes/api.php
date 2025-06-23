<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

route::apiResource('events',EventController::class);
route::apiResource('events.attendees',AttendeeController::class)->scoped()->except('update');

?>