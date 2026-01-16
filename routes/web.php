<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Unified Login System - Single login for all users
Route::get('/login', [App\Http\Controllers\Auth\UnifiedLoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [App\Http\Controllers\Auth\UnifiedLoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [App\Http\Controllers\Auth\UnifiedLoginController::class, 'logout'])
    ->name('logout');

// Redirect old login routes to unified login
Route::get('/teacher/login', function () {
    return redirect('/login');
})->name('filament.teacher.auth.login');

Route::get('/admin/login', function () {
    return redirect('/login');
})->name('filament.admin.auth.login');
