<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthenticatedUserController
{
    public function __construct(
        #[CurrentUser]
        private User $user,
    ) {}

    public function __invoke(Request $request): Response
    {
        return new JsonResponse(
            data: $this->user,
            status: Response::HTTP_OK,
        );
    }
}
