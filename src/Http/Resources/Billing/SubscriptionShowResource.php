<?php

namespace RedRockDigital\Api\Http\Resources\Billing;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Laravel\Cashier\Subscription;
use RedRockDigital\Api\Models\Stripe\Subscription as StripeSubscription;
use RedRockDigital\Api\Models\SubscriptionPlan;

/**
 * @mixin StripeSubscription
 * @mixin SubscriptionPlan
 */
class SubscriptionShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->plan->name,
            'tier'               => $this->plan->static,
            'price'              => $this->plan->price,
            'status'             => $this->stripe_status,
            'next_payment_date'  => $this->next_payment_date,
            'is_trial'           => $this->owner->trial_ends_at !== null,
            'trial_end'          => $this->owner->trial_ends_at,
            'allowances'         => $this->owner->allowances,
        ];
    }
}
