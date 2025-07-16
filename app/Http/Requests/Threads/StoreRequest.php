<?php

declare(strict_types=1);

namespace App\Http\Requests\Threads;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Threaddit\Domains\Posting\DataObjects\NewThread;

final class StoreRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                'string',
            ],
        ];
    }

    public function payload(string $user): NewThread
    {
        return new NewThread(
            body: $this->string('body')->toString(),
            user: $user,
        );
    }
}
