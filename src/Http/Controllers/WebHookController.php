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
        Webhook::create([
            'originator' => 'stripe',
            'hook'       => $request->type,
            'payload'    => $request->data,
            'idem_key'   => $request->idem_key,
        ]);

        return $this->response->respond(['message' => 'Stripe Webhook Received']);
    }
}
