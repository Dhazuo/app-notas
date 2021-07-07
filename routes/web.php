<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;

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
Route::get('/', [\App\Http\Controllers\MainIndexController::class, 'main_index'])
    ->name('index');
Route::post('/', [\App\Http\Controllers\MainIndexController::class, 'login'])
    ->name('custom_login');
Route::get('notes/per-categories', [\App\Http\Controllers\NoteCategoryController::class, 'category_index'])
    ->name('notes.categories')
    ->middleware('auth:sanctum');
Route::resource('notes', \App\Http\Controllers\NoteController::class)
    ->middleware('auth:sanctum');

/* Fortify::loginView(function () {
    return Inertia::render('Auth/Login2', [
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status'),
    ]);
}); */
