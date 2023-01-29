<?php

namespace RedRockDigital\Api\Http\Resources\Billing;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Laravel\Cashier\Subscription;

/**
 * @mixin Subscription
 * @mixin \RedRockDigital\Api\Models\Subscription
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
            'name'               => $this->name,
            'price'              => $this->price,
            'status'             => $this->stripe_status,
            'next_payment_date'  => $this->next_payment_date,
            'is_trial'           => $this->owner->trial_ends_at !== null,
            'trial_end'          => $this->owner->trial_ends_at,
            'tier'               => $this->owner->tier,
            'tier'               => $this->owner->friendly_tier_name,
            'friendly_tier_name' => $this->owner->friendly_tier_name,
            'allowances'         => $this->owner->allowances,
        ];
    }
}
