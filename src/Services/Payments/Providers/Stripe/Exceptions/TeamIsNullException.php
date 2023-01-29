<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class TeamIsNullException
 */
final class TeamIsNullException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message:  'Team cannot be passed as NULL',
            previous: $previous
        );
    }
}
