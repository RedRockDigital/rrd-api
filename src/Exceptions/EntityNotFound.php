<?php

namespace RedRockDigital\Api\Exceptions;

use Exception;
use Illuminate\Http\Response;

/**
 * Class EntityNotFound
 */
class EntityNotFound extends Exception
{
    /**
     * Set the error message string
     *
     * @var string
     */
    public $message = 'The record you are looking for no longer or did not exist.';

    /**
     * Set the error code
     *
     * @var string
     */
    public $code = Response::HTTP_NOT_FOUND;
}
