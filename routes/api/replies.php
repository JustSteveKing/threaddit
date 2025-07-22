<?php

declare(strict_types=1);

use App\Http\Controllers\Replies;
use Illuminate\Support\Facades\Route;

Route::post('/', Replies\StoreController::class)->name('store');
