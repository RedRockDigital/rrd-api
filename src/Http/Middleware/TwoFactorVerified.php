<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\{
    JsonResponse,
    RedirectResponse,
    Request,
    Response
};

class TwoFactorVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse|RedirectResponse|Response
     *
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse|Response
    {
        if ($request->user() && $request->user()?->two_factor_enabled && !$request->user()?->two_factor_verified) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
