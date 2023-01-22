<?php

namespace App\Http\Middleware\Webhooks;

use App\Exceptions\Webhooks\StripeIdempotencyKeyException;
use App\Models\Webhook;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class StripeIdempotencyKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return JsonResponse|RedirectResponse|Response
     * @throws StripeIdempotencyKeyException
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse|Response
    {
        // Before we begin, we will check to see if we are
        // processing, or finished a event with the same idem_key
        // if we have, we will bin this request off.
        $webhook = Webhook::whereIdemKey($idemKey = Arr::get($request->toArray(), 'request.idempotency_key'))
            ->whereIn('status', ['processing', 'completed'])->first();

        if ($webhook !== null) {
            throw new StripeIdempotencyKeyException($idemKey);
        }

        return $next($request);
    }
}
