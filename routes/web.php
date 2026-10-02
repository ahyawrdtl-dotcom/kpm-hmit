<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasController;

Route::get('/', function () {
    return view('index');
});

Route::get('/bendahara', function () {
    return view('bendahara');
})->name('bendahara');

Route::get('/kas', [KasController::class, 'index'])->name('kas');
Route::get('/kas/refresh', [KasController::class, 'refresh'])->name('kas.refresh');

