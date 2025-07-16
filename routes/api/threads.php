<?php

declare(strict_types=1);

use App\Http\Controllers\Threads;
use Illuminate\Support\Facades\Route;

Route::get('/', Threads\IndexController::class)->name('index');
Route::post('/', Threads\StoreController::class)->name('store');
Route::get('{ulid}', Threads\ShowController::class)->name('show');
