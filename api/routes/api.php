<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WasteController;

Route::post('/waste/upload', [WasteController::class, 'upload']);
Route::get('/waste/logs', [WasteController::class, 'logs']);
Route::get('/waste/stats', [WasteController::class, 'stats']);
