<?php

namespace RedRockDigital\Api\Http\Middleware\Webhooks;

use RedRockDigital\Api\Exceptions\Webhooks\StripeIdempotencyKeyException;
use RedRockDigital\Api\Models\Webhook;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookMiddleware
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
        // We will construct the webhook and check the signature
        // if the signature is invalid, we will throw an exception
        // and return a 400 response.
        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $request->header('stripe-signature'),
                config('cashier.webhook.secret')
            );

            // Before we begin, we will check to see if we are
            // processing, or finished a event with the same idem_key
            // if we have, we will bin this request off.
            if (Webhook::checkIdemKey($idemKey = Arr::get($request->toArray(), 'request.idempotency_key'))) {
                throw new StripeIdempotencyKeyException($idemKey);
            }
        } catch (SignatureVerificationException $e) {
            Webhook::markAsFailed($idemKey);
            return \response()->json(['message' => $e->getMessage()], 400);
        } catch (StripeIdempotencyKeyException $e) {
            return \response()->json(['message' => $e->getMessage()], 400);
        }

        return $next($request);
    }
}
