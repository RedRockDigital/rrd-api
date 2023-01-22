<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Events\UserUpdated;
use RedRockDigital\Api\Models\Pivot\TeamUser;
use RedRockDigital\Api\Notifications\VerifyEmailNotification;
use RedRockDigital\Api\Traits\{
    HasGroup,
    HasInformable,
    HasModelRoutes,
    HasTwoFactor,
    HasUuid
};
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{
    BelongsToMany,
    HasOne
};
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Prunable
};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\{
    DatabaseNotification,
    DatabaseNotificationCollection,
    Notifiable
};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{
    Config,
    URL
};
use Laravel\Passport\{
    Client,
    HasApiTokens
};

/**
 * RedRockDigital\Api\Models\User
 *
 * @property string                                                     $id
 * @property string|null                                                $current_team_id
 * @property string                                                     $first_name
 * @property string                                                     $last_name
 * @property string                                                     $email
 * @property Carbon|null                                                $email_verified_at
 * @property string                                                     $password
 * @property bool                                                       $change_password
 * @property Carbon|null                                                $change_password_at
 * @property bool                                                       $reminded_to_register
 * @property bool                                                       $suspended
 * @property string|null                                                $remember_token
 * @property Carbon|null                                                $created_at
 * @property Carbon|null                                                $updated_at
 * @property-read Collection|Client[]                                   $clients
 * @property-read int|null                                              $clients_count
 * @property-read bool                                                  $email_verified
 * @property-read string                                                $full_name
 * @property-read Collection|Group[]                                    $groups
 * @property-read int|null                                              $groups_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                              $notifications_count
 * @property-read Team|null                                             $team
 * @property-read Collection|Team[]                                     $teams
 * @property-read int|null                                              $teams_count
 * @property-read Collection|Token[]                                    $tokens
 * @property-read int|null                                              $tokens_count
 * @property-read Collection|Informable[]                               $informs
 * @property-read int|null                                              $informs_count
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrentTeamId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRemindedToRegister($value)
 * @method static Builder|User whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasGroup;
    use HasModelRoutes;
    use HasTwoFactor;
    use HasUuid;
    use Notifiable;
    use Prunable;
    use HasInformable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'change_password',
        'change_password_at',
        'reminded_to_register',
        'current_team_id',
        'suspended',
        'referral',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'full_name',
        'email_verified',
        'is_setup',
        'two_factor_enabled',
        'two_factor_verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'         => 'datetime',
        'email_verified'            => 'boolean',
        'reminded_to_register'      => 'boolean',
        'suspended'                 => 'boolean',
        'is_setup'                  => 'boolean',
        'two_factor_enabled'        => 'bool',
        'two_factor_verified'       => 'bool',
        'two_factor_secret'         => 'encrypted',
        'two_factor_recovery_codes' => 'encrypted',
        'last_logged_in_at'         => 'datetime',
        'two_factor_verified_at'    => 'datetime',
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->getOriginal('email') !== $model->email) {
                $model->email_verified_at = null;
            }
        });
    }

    /**
     * @var string[]
     */
    protected $dispatchesEvents = [
        'updated' => UserUpdated::class,
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return bool
     */
    public function getEmailVerifiedAttribute(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return bool
     */
    public function getIsSetupAttribute(): bool
    {
        return $this->full_name && $this->password;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @param string $email
     *
     * @return ?User
     */
    public function findForPassport(string $email): ?User
    {
        return $this->where(config('base.auth.username'), $email)->first();
    }

    /**
     * @return BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->using(TeamUser::class);
    }

    /**
     * @return HasOne
     */
    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'current_team_id');
    }

    /**
     * @return User
     */
    public function prune(): User
    {
        return static::where('created_at', '<=', now()->subWeeks(4));
    }

    /**
     * Send the email verification notification.
     *
     * @param bool $isReminder
     *
     *
     * @return void
     */
    public function sendEmailVerificationNotification(bool $isReminder = false): void
    {
        $this->notify(new VerifyEmailNotification($isReminder));
    }

    /**
     * Switch the user's context to the given team.
     *
     * @param Team $team
     *
     * @return void
     * @throws Exception
     */
    public function switchTeam(Team $team): void
    {
        if (!$this->belongsToTeam($team)) {
            throw new Exception('Attempting to access a team without permissions');
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('team', $team);
    }

    /**
     * Determine if the user belongs to the given team.
     *
     * @param Team $team
     *
     * @return bool
     */
    public function belongsToTeam(Team $team): bool
    {
        return $this->teams->contains(function ($t) use ($team) {
            return $t->id === $team->id;
        });
    }

    /**
     * @return string|null
     */
    public function getUpdateRoute(): ?string
    {
        return route('team.users.update', $this->id);
    }

    /**
     * @return string|null
     */
    public function getDeleteRoute(): ?string
    {
        return route('team.users.destroy', $this->id);
    }

    /**
     * @return string
     */
    public function getVerificationUrl(): string
    {
        return URL::temporarySignedRoute(
            'frontend.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id'   => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function authoriseVerification(string $token): bool
    {
        return hash_equals($token, sha1($this->getEmailForVerification()));
    }
}
