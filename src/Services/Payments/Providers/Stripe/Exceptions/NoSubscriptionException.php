<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class NoSubscriptionException
 */
final class NoSubscriptionException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @param  Throwable|null  $previous
     * @param  string  $teamId
     */
    public function __construct(?Throwable $previous = null, string $teamId = '')
    {
        parent::__construct(
            message:  "Team ($teamId) does not have active subscription.",
            previous: $previous
        );
    }
}
