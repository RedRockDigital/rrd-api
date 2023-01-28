<?php

namespace RedRockDigital\Api\Http\Middleware;

use Closure;
use Illuminate\Http\{RedirectResponse, Request, Response};

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        foreach (config('base.security_headers') as $header => $value) {
            $response->headers->set($header, $value);
        }

        return $response;
    }
}
