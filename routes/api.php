<?php

use Illuminate\Http\Request;
use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {
    Route::apiResource('notes', NotesController::class);
    Route::apiResource('comments', CommentController::class);
});
