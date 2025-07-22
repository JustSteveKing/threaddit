<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ThreadObserver;
use ArrayObject;
use Carbon\CarbonInterface;
use Database\Factories\ThreadFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $body
 * @property null|ArrayObject $meta
 * @property int $reactions
 * @property int $views
 * @property string $user_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property-read User $user
 * @property-read Collection<int,Reply> $replies
 */
#[ObservedBy(classes: ThreadObserver::class)]
final class Thread extends Model
{
    /** @use HasFactory<ThreadFactory> */
    use HasFactory;
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'body',
        'meta',
        'reactions',
        'views',
        'user_id',
    ];

    /** @var list<string|class-string> */
    protected $casts = [
        'meta' => AsArrayObject::class,
        'reactions' => 'integer',
        'views' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    public function replies(): HasMany
    {
        return $this->hasMany(
            related: Reply::class,
            foreignKey: 'thread_id',
        )->orderBy('created_at', 'desc');
    }
}
