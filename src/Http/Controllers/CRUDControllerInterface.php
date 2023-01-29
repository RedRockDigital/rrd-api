<?php

namespace RedRockDigital\Api\Http\Controllers;

/**
 * Interface CRUDControllerInterface
 */
interface CRUDControllerInterface
{
    /**
     * Define array of requests against actions
     *
     * @return array
     */
    public function requests(): array;

    /**
     * Define array of responses against actions
     *
     * @return array
     */
    public function responses(): array;

    /**
     * Define the Model the Controller will interact with
     *
     * @return string
     */
    public function model(): string;

    /**
     * Define the scopes required for each action
     *
     * @return array
     */
    public function scopes(): array;
}
