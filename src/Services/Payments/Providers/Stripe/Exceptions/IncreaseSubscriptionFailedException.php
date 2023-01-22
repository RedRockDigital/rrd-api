<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class IncreaseSubscriptionFailedException
 */
final class IncreaseSubscriptionFailedException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(?Throwable $previous = null, string $teamId = '')
    {
        parent::__construct(
            message:  "Team ($teamId) was unable to increase the quantity of the subscription:".$previous->getMessage(),
            previous: $previous
        );
    }
}
