<?php

declare(strict_types=1);

namespace App\Modules\Identity\Resources;

use App\Modules\Identity\Models\User;
use App\Shared\Resources\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read User $resource */
final class UserResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'details' => [
                'name' => $this->resource->name,
                'handle' => $this->resource->handle,
                'email' => [
                    'address' => $this->resource->email,
                    'verified' => $this->resource->hasVerifiedEmail(),
                ],
                'status' => $this->resource->status->value,
                'bio' => $this->resource->bio,
            ],
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
        ];
    }
}
