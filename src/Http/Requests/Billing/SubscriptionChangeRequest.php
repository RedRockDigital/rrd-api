<?php

namespace RedRockDigital\Api\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class SubscriptionChangeRequest
 *
 * @property-read string $tier
 * @property-read int    $tierAmount
 */
class SubscriptionChangeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tier' => ['required', Rule::in(array_keys(config('payments.stripe.tiers')))],
        ];
    }

    /**
     * Prepare For Validation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $tier = $this->request->get('tier');
        $tiers = config('payments.stripe.tiers');

        if (array_key_exists($tier, $tiers)) {
            $this->tierAmount = $tiers[$tier];
        }
    }
}
