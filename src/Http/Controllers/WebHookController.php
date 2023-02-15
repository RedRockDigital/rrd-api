<?php

namespace RedRockDigital\Api\Http\Controllers;

use RedRockDigital\Api\Http\Requests\Webhooks\StripeWebhookRequest;
use RedRockDigital\Api\Models\Webhook;
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
        'webhooks.stripe' => false,
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
