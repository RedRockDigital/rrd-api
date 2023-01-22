<?php

namespace RedRockDigital\Api\Events;

use RedRockDigital\Api\Models\Team;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeamCreated
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public readonly Team $team)
    {
    }
}
