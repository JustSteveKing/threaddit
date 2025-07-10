<?php

declare(strict_types=1);

use App\Modules\Identity\Controllers\AuthenticatedUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->as('auth:')->group(base_path(
    path: 'routes/api/auth.php',
));

Route::middleware(['auth:sanctum'])->group(static function (): void {
    Route::prefix('threads')->as('threads:')->group(base_path(
        path: 'routes/api/threads.php',
    ));


    Route::get('/user', AuthenticatedUserController::class);
});
