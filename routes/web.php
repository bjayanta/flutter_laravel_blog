<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// create storage-link
Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage Link generated';
});

// artisan route
Route::prefix('artisan')->group(function () {
    // create storage-link
    Route::get('storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage Link generated';
    });
    
});

