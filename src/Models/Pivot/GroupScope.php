<?php

namespace RedRockDigital\Api\Models\Pivot;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * RedRockDigital\Api\Models\Pivot\GroupScope
 *
 * @property string $group_id
 * @property string $scope_id
 *
 * @method static Builder|GroupScope newModelQuery()
 * @method static Builder|GroupScope newQuery()
 * @method static Builder|GroupScope query()
 * @method static Builder|GroupScope whereGroupId($value)
 * @method static Builder|GroupScope whereScopeId($value)
 *
 * @mixin Eloquent
 */
class GroupScope extends Pivot
{
    /**
     * @var array
     */
    protected $fillable = [
        'group_id', 'scope_id',
    ];
}
