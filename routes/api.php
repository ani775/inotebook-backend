<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth.api'])->group(function() {
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/addnotes', [NoteController::class, 'addNote']);
    Route::get('/fecthnotes', [NoteController::class, 'fetchNotes']);
    Route::post('/updatenotes/{id}', [NoteController::class, 'updateNote']);
    Route::post('/deletenotes/{id}', [NoteController::class, 'deleteNote']);
    //Route::put('/updatenotes/{id}', [NoteController::class, 'updateNote']);
    //Route::delete('/deletenotes/{id}', [NoteController::class, 'deleteNote']);
});
