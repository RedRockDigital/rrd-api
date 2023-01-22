<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaymentMethodStoreRequest
 *
 * @property-read string $pm
 */
class PaymentMethodStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'pm' => ['required', 'string'],
        ];
    }
}
