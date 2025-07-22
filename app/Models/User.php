<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property string $id
 * @property string $name
 * @property null|string $handle
 * @property string $email
 * @property string $password
 * @property null|string $remember_token
 * @property Status $status
 * @property null|string $bio
 * @property null|CarbonInterface $email_verified_at
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property null|CarbonInterface $deleted_at
 * @property-read Collection<int,PersonalAccessToken> $tokens
 * @property-read null|PersonalAccessToken $currentAccessToken
 * @property-read Collection<int,Thread> $threads
 * @property-read Collection<int,Reply> $replies
 */
final class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasUlids;
    use Notifiable;
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'handle',
        'email',
        'password',
        'remember_token',
        'status',
        'bio',
        'email_verified_at',
    ];

    /** @var list<string|class-string> */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => Status::class,
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(
            related: Thread::class,
            foreignKey: 'user_id',
        );
    }

    public function replies(): HasMany
    {
        return $this->hasMany(
            related: Reply::class,
            foreignKey: 'user_id',
        )->orderBy('created_at', 'desc');
    }

    public static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
