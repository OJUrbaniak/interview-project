<?php

use App\Http\Controllers\PostSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('search');
});

Route::get('/all', [PostSearchController::class, 'allProperties']);
Route::post('search', [PostSearchController::class, 'search']);
