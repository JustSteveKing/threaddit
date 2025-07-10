<?php

declare(strict_types=1);

use App\Modules\Identity\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('login', Controllers\LoginController::class)->name('login');

