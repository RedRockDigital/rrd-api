<?php

namespace RedRockDigital\Api\Http\Resources\Billing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Stripe\PaymentMethod;

/**
 * @mixin PaymentMethod
 */
class PaymentMethodShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'card'            => $this->type,
            'brand'           => $this->card->brand,
            'country'         => $this->card->country,
            'exp_month'       => $this->card->exp_month,
            'exp_year'        => $this->card->exp_year,
            'last4'           => $this->card->last4,
            'billing_details' => [
                'line_one'    => $this->billing_details->line1,
                'line_two'    => $this->billing_details->line2,
                'postal_code' => $this->billing_details->postal_code,
                'country'     => $this->billing_details->country,
                'city'        => $this->billing_details->city,
            ],
            'created_at'      => $this->created,
        ];
    }
}
