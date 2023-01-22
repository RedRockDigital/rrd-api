<?php

namespace RedRockDigital\Api\Http\Controllers;

use RedRockDigital\Api\Http\Response;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Defines a list of Scope required for Auth checking
     * against a route -> action.
     *
     * @var array
     */
    public array $scopes = [];

    /**
     * @constructor
     *
     * @param  Response  $response
     */
    public function __construct(protected Response $response = new Response())
    {
        $this->authorize();
    }

    /**
     * @return void
     */
    private function authorize(): void
    {
        $this->middleware(function ($request, Closure $next) {
            // If the route name does not exist on the current controllers scope array
            // We will throw the user an un-authenticated exception
            if (!array_key_exists($routeName = $request->route()->getName(), $this->scopes)) {
                throw new AuthenticationException();
            }

            // Check to see if the User has the required scope against their group
            // If they don't throw them an un-authenticated exception
            // Furthermore, if the scope is false, continue as normal.
            if (($scope = $this->scopes[$routeName])) {
                if (!$request->user() || !$request->user()->hasScope($scope)) {
                    throw new AuthenticationException();
                }
            }

            return $next($request);
        });
    }
}
