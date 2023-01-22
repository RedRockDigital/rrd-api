<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Traits\HasUuid;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * RedRockDigital\Api\Models\Informable
 *
 * @property string              $id
 * @property string              $name
 * @property string              $owner_type
 * @property string              $owner_id
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property-read Model|Eloquent $owner
 *
 * @method static Builder|Informable newModelQuery()
 * @method static Builder|Informable newQuery()
 * @method static Builder|Informable query()
 * @method static Builder|Informable whereCreatedAt($value)
 * @method static Builder|Informable whereId($value)
 * @method static Builder|Informable whereName($value)
 * @method static Builder|Informable whereOwnerId($value)
 * @method static Builder|Informable whereOwnerType($value)
 * @method static Builder|Informable whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Informable extends Model
{
    use HasUuid;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * @return MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo('owner');
    }
}
