<?php

declare(strict_types=1);

namespace App\Modules\Posting\Requests\Threads;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
}
