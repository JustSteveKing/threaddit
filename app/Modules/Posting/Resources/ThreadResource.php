<?php

declare(strict_types=1);

namespace App\Modules\Posting\Resources;

use App\Modules\Identity\Resources\UserResource;
use App\Modules\Posting\Models\Thread;
use App\Shared\Resources\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Thread $resource */
final class ThreadResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'content' => [
                'body' => $this->resource->body,
                'meta' => $this->resource->meta,
                'reactions' => $this->resource->reactions,
            ],
            'user' => new UserResource(
                resource: $this->whenLoaded(
                    relationship: 'user',
                ),
            ),
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
        ];
    }
}
