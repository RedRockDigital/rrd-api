<?php

namespace RedRockDigital\Api\Http\Resources\Team;

use RedRockDigital\Api\Http\Resources\Billing\SubscriptionShowResource;
use RedRockDigital\Api\Models\Team;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin Team */
class TeamResource extends JsonResource
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
        $canAccessBilling = $request->user()->hasScope('team.manage-billing');

        return [
            'id'                  => $this->id,
            'owner_id'            => $this->owner_id,
            'name'                => $this->name,
            'has_onboarded'       => $this->has_onboarded,
            'payment_failed'      => $this->payment_failed,
            'features'            => $this->features,
            'subscription'        => new SubscriptionShowResource($this->subscription()),
            'stripe_id'           => $this->when($canAccessBilling, $this->stripe_id),
            'pm_type'             => $this->when($canAccessBilling, $this->pm_type),
            'pm_last_four'        => $this->when($canAccessBilling, $this->pm_last_four),
            'billing_information' => $this->when($canAccessBilling, $this->billing_information),
            'tier'                => $this->when($canAccessBilling, $this->tier),
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}
