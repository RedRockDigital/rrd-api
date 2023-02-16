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

/**
 * Class StripeWebhookMiddleware
 */
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
        try {
            // Construct the Stripe Event
            // If the signature is invalid, throw an exception
            \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $request->header('stripe-signature'),
                config('services.stripe.webhook_secret')
            );

            // Check if the idempotency key has been used before
            // If it has, throw an exception
            if (Webhook::checkIdemKey($key = Arr::get($request->toArray(), 'request.idempotency_key'))) {
                throw new StripeIdempotencyKeyException($key);
            }
        } catch (SignatureVerificationException $e) {
            return response()->json(['message' => 'Invalid Webhook Signature Provided'], Response::HTTP_BAD_REQUEST);
        } catch (StripeIdempotencyKeyException $e) {
            return response()->json(['message' => 'Idempotency Key Already Used'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Webhook Request'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $next($request);
    }
}
