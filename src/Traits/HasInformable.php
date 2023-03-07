<?php

namespace RedRockDigital\Api\Traits;

use RedRockDigital\Api\Enums\InformEnums;
use RedRockDigital\Api\Models\Informable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * @property-read Informable[]|Collection $informs
 */
trait HasInformable
{
    /**
     * @return MorphMany
     */
    public function informs(): MorphMany
    {
        return $this->morphMany(Informable::class, 'owner');
    }

    /**
     * Determine if the Owner can be informed of a type.
     *
     * @param object $inform
     *
     * @return bool
     */
    public function canBeInformed(object $inform): bool
    {
        // Find the informative record enum type via the informs table.
        // If it does, return true else false, via the ->exists() method.
        return $this->informs()->where('name', $inform->name)->exists();
    }

    /**
     * @param object $inform
     *
     * @return void
     */
    public function inform(object $inform): void
    {
        // If the informative record does not exist,
        // We will then perform a creation against the owner.
        if ($this->canBeInformed($inform) === false) {
            $this->informs()->create(['name' => $inform->name]);
        }
    }

    /**
     * @param object $inform
     *
     * @return void
     */
    public function unInform(object $inform): void
    {
        // If the informative record exists,
        // We will perform a deletion against the owner.
        if ($this->canBeInformed($inform)) {
            $this->informs()->where('name', $inform->name)->delete();
        }
    }
}
