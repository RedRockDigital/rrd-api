<?php

namespace RedRockDigital\Api\Http\Controllers\Billing;

use RedRockDigital\Api\Actions\Subscription\CancelSubscriptionAction;
use RedRockDigital\Api\Actions\Subscription\ChangeSubscriptionAction;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Billing\{
    SubscriptionChangeRequest
};
use RedRockDigital\Api\Http\Resources\Billing\SubscriptionShowResource;
use RedRockDigital\Api\Services\Payments\Payments;
use Illuminate\Http\JsonResponse;

/**
 * Final Class SubscriptionController
 */
final class SubscriptionController extends Controller
{
    /**
     * @var array
     */
    public array $scopes = [
        'billing.subscription.show'   => 'team.manage-billing',
        'billing.subscription.change' => 'team.manage-billing',
        'billing.subscription.cancel' => 'team.manage-billing',
        'billing.subscription.resume' => 'team.manage-billing',
    ];

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return $this
            ->response
            ->respond(new SubscriptionShowResource(Payments::getSubscription(team())));
    }

    /**
     * @param SubscriptionChangeRequest $request
     * @param ChangeSubscriptionAction  $changeSubscriptionAction
     *
     * @return JsonResponse
     */
    public function change(
        SubscriptionChangeRequest $request,
        ChangeSubscriptionAction $changeSubscriptionAction
    ): JsonResponse {
        $changeSubscriptionAction(tier: $request->tier);

        return $this
            ->response
            ->respond(['message' => __('payments.subscription.change')]);
    }

    /**
     * @param CancelSubscriptionAction $cancelSubscriptionAction
     *
     * @return JsonResponse
     */
    public function cancel(
        CancelSubscriptionAction $cancelSubscriptionAction
    ): JsonResponse {
        $cancelSubscriptionAction();

        return $this
            ->response
            ->respond(['message' => __('payments.subscription.cancel')]);
    }

    /**
     * @return JsonResponse
     */
    public function resume(): JsonResponse
    {
        Payments::resumeSubscription(team());

        return $this
            ->response
            ->respond(['message' => __('payments.subscription.cancel')]);
    }
}
