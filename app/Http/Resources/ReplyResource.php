<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Reply $resource */
final class ReplyResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'content' => [
                'status' => $this->resource->status->value,
                'body' => $this->resource->body,
                'meta' => $this->resource->meta,
            ],
            'user' => new UserResource(
                resource: $this->whenLoaded(
                    relationship: 'user',
                ),
            ),
            'thread' => new ThreadResource(
                resource: $this->whenLoaded(
                    relationship: 'thread',
                ),
            ),
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
        ];
    }
}
