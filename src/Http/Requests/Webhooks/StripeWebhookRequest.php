<?php

namespace App\Http\Requests\Webhooks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

/**
 * Class StripeWebhookRequest
 *
 * @property object $data
 * @property string $type
 * @property string $idem_key
 */
class StripeWebhookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => Rule::in([
                'invoice.payment_failed',
                'customer.subscription.updated',
                'customer.subscription.created',
                'customer.subscription.deleted',
            ]),
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        $baseArray = $this->toArray();

        $this->type = Arr::get($baseArray, 'type');
        $this->data = Arr::get($baseArray, 'data');
        $this->idem_key = Arr::get($baseArray, 'request.idempotency_key') ?? Arr::get($baseArray, 'id');
    }
}
