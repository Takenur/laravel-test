<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Пока написал все в web.php
 */

Route::get('/', [HomeController::class,'index']);
Route::prefix('news')->group(function () {
    Route::get('/',[PostController::class,'index']);
    Route::get('{id}', [PostController::class,'single']);
    Route::post('create', [PostController::class,'create']);
    Route::post('{id}/update', [PostController::class,'update']);
    Route::delete('{id}',[PostController::class,'delete']);
});

Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class,'index']);
    Route::get('{id}', [CommentController::class,'single']);
    Route::post('create',[CommentController::class,'create']);
    Route::post('{id}/update', [CommentController::class,'update']);
    Route::delete('{id}',[CommentController::class,'delete']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
