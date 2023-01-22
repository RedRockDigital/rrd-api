<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use App\Traits\HasUuid;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\PasswordResetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Prunable,
    Relations\BelongsTo
};
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\PasswordReset
 *
 * @property string $id
 * @property string $user_id
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static PasswordResetFactory factory(...$parameters)
 * @method static Builder|PasswordReset newModelQuery()
 * @method static Builder|PasswordReset newQuery()
 * @method static Builder|PasswordReset query()
 * @method static Builder|PasswordReset whereCreatedAt($value)
 * @method static Builder|PasswordReset whereEmail($value)
 * @method static Builder|PasswordReset whereId($value)
 * @method static Builder|PasswordReset whereToken($value)
 * @method static Builder|PasswordReset whereUpdatedAt($value)
 * @method static Builder|PasswordReset whereUserId($value)
 *
 * @mixin Eloquent
 */
class PasswordReset extends Model
{
    use HasFactory;
    use HasUuid;
    use Prunable;

    /**
     * Fill-able attributes for Organisation
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'email',
        'token',
        'created_at',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = array_merge($this->fillable, [
            config('base.auth.username'),
        ]);
    }

    /**
     * @boot
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($model) {
            if (!$model->token) {
                do {
                    $token = Str::random(128);
                } while (self::where('token', $token)->exists());

                $model->token = $token;
            }
        });
    }

    /**
     * Password Reset Belongs to User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the prunable model query.
     *
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subHours(2));
    }
}
