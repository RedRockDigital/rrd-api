<?php

namespace RedRockDigital\Api\Services\Payments;

use RedRockDigital\Api\Models\Team;
use Illuminate\Database\Eloquent\Model;

/**
 * Final Class Limits
 */
final class Limits
{
    /**
     * Determine if the Allowance key is over or under
     * the configured amount.
     *
     * @param  string  $name
     * @param  string  $dir
     * @param  Team|null  $team
     * @return bool|null
     */
    public static function determineStaticLimit(string $name = '', string $dir = 'more', ?Team $team = null): ?bool
    {
        // Fetch the configured allowances from the payments config
        $configured = Payments::getAllowances($team ?? team());

        // Match the correct direction, and the compare against the configured amount.
        return match ($dir) {
            'more'  => (int) Limits::getLimit($name, $team) >= $configured[$name],
            'less'  => (int) Limits::getLimit($name, $team) <= $configured[$name],
            default => null
        };
    }

    /**
     * @param  Model  $model
     * @param  string  $name
     * @param  string  $dir
     * @param  Team|null  $team
     * @return bool|null
     */
    public static function determineModelLimit(
        Model $model,
        string $name = '',
        string $dir = 'more',
        ?Team $team = null
    ): ?bool {
        $count = $model->where('team_id', ($team ?? team())->id)->count('id');

        // Match the correct direction, and the compare against the configured amount.
        return match ($dir) {
            'more'  => (int) Limits::getLimit($name, $team) >= $count,
            'less'  => (int) Limits::getLimit($name, $team) <= $count,
            default => null
        };
    }

    /**
     * @param  string|null  $name
     * @param  Team|null  $team
     * @return bool
     */
    public static function hasLimit(string $name = null, ?Team $team = null): bool
    {
        return isset(($team ?? team())->allowances[$name]);
    }

    /**
     * @param  string|null  $name
     * @param  Team|null  $team
     * @return ?string
     */
    public static function getLimit(string $name = null, ?Team $team = null): ?string
    {
        if (self::hasLimit($name, $team)) {
            return ($team ?? team())->allowances[$name];
        }

        return null;
    }

    /**
     * @param  string|null  $name
     * @param  string|int|null  $value
     * @param  bool  $dry
     * @param  Team|null  $team
     * @return bool
     */
    public static function setLimit(
        string $name = null,
        string|int $value = null,
        bool $dry = false,
        ?Team $team = null
    ): bool {
        if ($dry || self::hasLimit($name, $team)) {
            ($team ?? team())->update([
                'allowances' => array_merge($team->allowances ?? [], [
                    $name => $value,
                ]),
            ]);

            return true;
        }

        return false;
    }
}
