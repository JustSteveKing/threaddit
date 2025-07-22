<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\ReplyFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Threaddit\Domains\Posting\Enums\ReplyStatus;

/**
 * @property string $id
 * @property ReplyStatus $status
 * @property string $body
 * @property array|null $meta
 * @property string $thread_id
 * @property string $user_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property-read Thread $thread
 * @property-read User $user
 */
final class Reply extends Model
{
    /** @use HasFactory<ReplyFactory> */
    use HasFactory;
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'status',
        'body',
        'meta',
        'thread_id',
        'user_id',
    ];

    /** @var list<class-string> */
    protected $casts = [
        'status' => ReplyStatus::class,
        'meta' => AsArrayObject::class,
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(
            related: Thread::class,
            foreignKey: 'thread_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }
}
