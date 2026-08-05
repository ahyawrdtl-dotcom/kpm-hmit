<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/bendahara', function () {
    return view('bendahara');
})->name('bendahara');
