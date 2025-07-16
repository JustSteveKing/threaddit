<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;
use Symfony\Component\HttpFoundation\Response;

final class LoginController
{
    /**
     * @param LoginRequest $request
     * @return Response
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request): Response
    {
        $request->authenticate();

        /** @var NewAccessToken $token */
        $token = $request->user()->createToken('API Token');

        return new JsonResponse(
            data: [
                'token' => $token->plainTextToken,
            ],
            status: Response::HTTP_OK,
        );
    }
}
