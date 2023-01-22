<?php

namespace App\Models\Pivot;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\Pivot\TeamUser
 *
 * @property string $team_id
 * @property string $user_id
 * @property string $group_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|TeamUser newModelQuery()
 * @method static Builder|TeamUser newQuery()
 * @method static Builder|TeamUser query()
 * @method static Builder|TeamUser whereCreatedAt($value)
 * @method static Builder|TeamUser whereGroupId($value)
 * @method static Builder|TeamUser whereTeamId($value)
 * @method static Builder|TeamUser whereUpdatedAt($value)
 * @method static Builder|TeamUser whereUserId($value)
 *
 * @mixin Eloquent
 */
class TeamUser extends Pivot
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'team_id', 'user_id', 'group_id',
    ];
}
