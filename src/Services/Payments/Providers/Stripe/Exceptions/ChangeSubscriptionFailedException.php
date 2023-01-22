<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Throwable;

/**
 * Class ChangeSubscriptionFailedException
 */
final class ChangeSubscriptionFailedException extends Exception
{
    /**
     * @param  Throwable|null  $previous
     * @param  string  $teamId
     */
    public function __construct(
        ?Throwable $previous = null,
        string $teamId = ''
    ) {
        parent::__construct(
            message:  "Team ($teamId) was unable change the subscription: {$previous->getMessage()}",
            code: $previous->getCode(),
            previous: $previous
        );
    }
}
