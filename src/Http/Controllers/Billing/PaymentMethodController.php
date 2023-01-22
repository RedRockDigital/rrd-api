<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\PaymentMethodStoreRequest;
use App\Http\Resources\Billing\PaymentMethodShowResource;
use App\Services\Payments\Payments;
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
