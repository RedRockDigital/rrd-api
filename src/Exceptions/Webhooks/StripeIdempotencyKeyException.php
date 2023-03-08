<?php

namespace RedRockDigital\Api\Exceptions\Webhooks;

use Exception;
use Illuminate\Http\Response;

/**
 * Class StripeIdempotencyKeyException
 *
 * @package RedRockDigital\Api\Exceptions\Webhooks
 */
class StripeIdempotencyKeyException extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(string $key = '', string $event = '')
    {
        parent::__construct("Idempotency Key ($key) for event ($event) is in-process or has been completed already.");
    }
}
