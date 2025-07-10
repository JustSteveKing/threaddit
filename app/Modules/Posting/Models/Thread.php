<?php

declare(strict_types=1);

namespace App\Modules\Posting\Models;

use App\Modules\Identity\Models\User;
use ArrayObject;
use Carbon\CarbonInterface;
use Database\Factories\ThreadFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $body
 * @property null|ArrayObject $meta
 * @property int $reactions
 * @property string $user_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property-read User $user
 */
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
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    /** @return array<string,string> */
    protected function casts(): array
    {
        return [
            'meta' => AsArrayObject::class,
            'reactions' => 'integer',
        ];
    }

    public static function newFactory(): ThreadFactory
    {
        return ThreadFactory::new();
    }
}
