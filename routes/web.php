<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministrasiController;

Route::resource('administrasi', AdministrasiController::class);
Route::get('/', function () {
    return view('welcome');
});
