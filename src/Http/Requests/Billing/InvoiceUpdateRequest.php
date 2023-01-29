<?php

namespace RedRockDigital\Api\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class InvoiceUpdateRequest
 *
 * @property-read string $information
 */
class InvoiceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'billing_information' => ['nullable', 'string'],
        ];
    }
}
