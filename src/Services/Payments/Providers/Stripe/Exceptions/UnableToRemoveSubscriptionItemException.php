<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class UnableToRemoveSubscriptionItemException
 */
final class UnableToRemoveSubscriptionItemException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @param  \Throwable|null  $previous
     * @param  string  $teamId
     * @param  string  $item
     */
    public function __construct(?\Throwable $previous = null, string $teamId = '', string $item = '')
    {
        parent::__construct(
            message: "Team ($teamId) was unable to remove subscription item (): ".$previous->getMessage(),
            previous: $previous
        );
    }
}
