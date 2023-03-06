<?php

namespace RedRockDigital\Api\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RedRockDigital\Api\Models\Team;

/**
 * Trait BelongsToTeam
 */
trait BelongsToTeam
{
    /**
     * @return void
     */
    public function initializeBelongsToTeam(): void
    {
        $this->fillable = array_merge($this->fillable, [
            'team_id',
        ]);

        static::creating(static function (Model $model) {
            $team = team();

            if ($team && !$model->team_id) {
                $model->team_id = $team->id;
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}