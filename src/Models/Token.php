<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Traits\HasModelRoutes;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\Token as PassportToken;

/**
 * RedRockDigital\Api\Models\Token
 *
 * @property string $id
 * @property string $user_id
 * @property int $client_id
 * @property string|null $name
 * @property array|null $scopes
 * @property bool $revoked
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property Carbon|null $expires_at
 * @property-read Client|null $client
 * @property-read array $routes
 * @property-read User $user
 *
 * @method static Builder|Token newModelQuery()
 * @method static Builder|Token newQuery()
 * @method static Builder|Token query()
 * @method static Builder|Token whereClientId($value)
 * @method static Builder|Token whereCreatedAt($value)
 * @method static Builder|Token whereExpiresAt($value)
 * @method static Builder|Token whereId($value)
 * @method static Builder|Token whereName($value)
 * @method static Builder|Token whereRevoked($value)
 * @method static Builder|Token whereScopes($value)
 * @method static Builder|Token whereUpdatedAt($value)
 * @method static Builder|Token whereUserId($value)
 *
 * @mixin Eloquent
 */
class Token extends PassportToken
{
    use HasModelRoutes;

    /**
     * @return string|null
     */
    public function getDeleteRoute(): ?string
    {
        return route('me.tokens.destroy', $this->id);
    }
}
