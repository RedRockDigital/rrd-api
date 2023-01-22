<?php

namespace RedRockDigital\Api\Http\Controllers\Billing;

use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Billing\PaymentMethodStoreRequest;
use RedRockDigital\Api\Http\Resources\Billing\PaymentMethodShowResource;
use RedRockDigital\Api\Services\Payments\Payments;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Final Class SubscriptionController
 */
final class PaymentMethodController extends Controller
{
    /**
     * @var array
     */
    public array $scopes = [
        'billing.payment-method.show'  => 'team.manage-billing',
        'billing.payment-method.store' => 'team.manage-billing',
    ];

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $paymentMethod = Payments::getPaymentMethods(team());

        return $paymentMethod
            ? $this->response->respond(new PaymentMethodShowResource($paymentMethod))
            : $this->response->respond([], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param PaymentMethodStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(PaymentMethodStoreRequest $request): JsonResponse
    {
        Payments::addPaymentMethod(
            team(),
            $request->pm
        );

        return $this->response
            ->created(['message' => __('payments.method.store')]);
    }
}
