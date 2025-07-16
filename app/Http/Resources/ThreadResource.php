<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Thread;
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
                'views' => $this->resource->views,
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
