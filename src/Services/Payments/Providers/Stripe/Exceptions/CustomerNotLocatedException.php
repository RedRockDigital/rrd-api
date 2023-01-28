<?php

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class CustomerNotLocatedException
 */
class CustomerNotLocatedException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @param  Throwable|null  $previous
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(
            message:  'Customer was not located and could not be created: '. $previous?->getMessage(),
            previous: $previous
        );
    }
}
