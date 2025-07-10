<?php

declare(strict_types=1);

use App\Modules\Posting\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', Controllers\Threads\IndexController::class)->name('index');
Route::post('/', Controllers\Threads\StoreController::class)->name('store');
