<?php

namespace RedRockDigital\Api\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

final class RoleNotFoundException extends Exception
{
    /**
     * Set the error message string
     * 
     * @var int $code
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
    
    /**
     * RoleNotFoundException constructor.
     * 
     * @param string $role
     */
    public function __construct(string $role)
    {
        parent::__construct("Role [{$role}] does not exist.");
    }
}