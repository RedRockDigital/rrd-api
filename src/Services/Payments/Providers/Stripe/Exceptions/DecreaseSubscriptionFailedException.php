<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class DecreaseSubscriptionFailedException
 */
final class DecreaseSubscriptionFailedException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @param  Throwable|null  $previous
     * @param  string  $teamId
     */
    public function __construct(?Throwable $previous = null, string $teamId = '')
    {
        parent::__construct(
            message: "Team ($teamId) was unable to decrease the quantity of the subscription: " . $previous->getMessage(),
            previous: $previous
        );
    }
}
