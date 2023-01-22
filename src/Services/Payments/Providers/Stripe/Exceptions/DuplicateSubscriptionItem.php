<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class DuplicateSubscriptionItem
 */
final class DuplicateSubscriptionItem extends Exception
{
    /**
     * Set the error code
     *
     * @var string
     */
    public $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @param  string  $item
     */
    public function __construct(string $item = '')
    {
        parent::__construct(message: "Duplicate subscription item has been used ($item)");
    }
}
