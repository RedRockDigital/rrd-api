<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class UnableToAddSubscriptionItemException
 */
final class UnableToAddSubscriptionItemException extends Exception
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
     */
    public function __construct(?\Throwable $previous = null, string $item = '')
    {
        parent::__construct(
            message: "Unable to add subscription item ($item): {$previous->getMessage()}",
            previous: $previous
        );
    }
}
