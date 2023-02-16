<?php

namespace RedRockDigital\Api\Http\Middleware;

use Closure;
use Illuminate\Http\{AuthenticationException, JsonResponse, RedirectResponse, Request, Response};
use Illuminate\Support\Facades\Auth;

/**
 * Class IsSuspended
 */
class IsSuspended
{
    /**
     * Determine if a User has been suspended and throw an authentication exception
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return JsonResponse|RedirectResponse|Response
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse|Response
    {
        if ($request->user()->suspended) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
