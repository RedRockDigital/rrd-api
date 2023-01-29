<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Models\Pivot\GroupScope;
use RedRockDigital\Api\Traits\HasUuid;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * RedRockDigital\Api\Models\Scope
 *
 * @property string $id
 * @property string $name
 * @property string $scope
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Group[] $groups
 * @property-read int|null $groups_count
 *
 * @method static Builder|Scope newModelQuery()
 * @method static Builder|Scope newQuery()
 * @method static Builder|Scope query()
 * @method static Builder|Scope whereCreatedAt($value)
 * @method static Builder|Scope whereId($value)
 * @method static Builder|Scope whereName($value)
 * @method static Builder|Scope whereScope($value)
 * @method static Builder|Scope whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Scope extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'scope',
    ];

    /**
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->using(GroupScope::class);
    }
}
