<?php

namespace App\Http\Controllers;

use App\Http\Requests\Webhooks\StripeWebhookRequest;
use App\Models\Webhook;
use Illuminate\Http\JsonResponse;

/**
 * Class WebHookController
 */
final class WebHookController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'webhooks.stripe.payment_failed'         => false,
        'webhooks.stripe.subscription_created'   => false,
        'webhooks.stripe.subscription_updated'   => false,
        'webhooks.stripe.subscription_deleted'   => false,
    ];

    /**
     * @param StripeWebhookRequest $request
     *
     * @return JsonResponse
     */
    public function stripe(StripeWebhookRequest $request): JsonResponse
    {
        $this->createHook(
            'stripe',
            $request->type,
            $request->data,
            $request->idem_key
        );

        return $this->response->respond(['message' => 'Stripe Webhook Received']);
    }

    /**
     * @param string $originator
     * @param string $hook
     * @param mixed  $payload
     * @param string $idemKey
     *
     * @return void
     */
    private function createHook(string $originator, string $hook, mixed $payload, string $idemKey): void
    {
        Webhook::create([
            'originator' => $originator,
            'hook'       => $hook,
            'payload'    => $payload,
            'idem_key'   => $idemKey,
        ]);
    }
}
