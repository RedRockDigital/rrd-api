<?php

namespace RedRockDigital\BedRock;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RedRockDigital\BedRock\Skeleton\SkeletonClass
 */
class BedRockFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bedrock';
    }
}
