<?php

declare(strict_types=1);

namespace App\Http\Requests\Replies;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Threaddit\Domains\Posting\DataObjects\NewReply;

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

    public function payload(string $thread, string $user): NewReply
    {
        return new NewReply(
            thread: $thread,
            user: $user,
            body: $this->string('body')->toString(),
        );
    }
}
