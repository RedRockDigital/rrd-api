<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class ResumeSubscriptionFailedException
 *
 * @package App\Services\Payments\Exceptions
 */
final class ResumeSubscriptionFailedException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(?string $teamId = null, ?Throwable $throwable = null)
    {
        parent::__construct(
            message:  "Team ($teamId) was unable to resume a subscription",
            previous: $throwable
        );
    }
}
