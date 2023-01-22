<?php

namespace RedRockDigital\Api\Http\Requests\Me;

use RedRockDigital\Api\Enums\InformEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $informable
 */
class UpdateInformableRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'informable' => ['required', Rule::in(
                array_column(InformEnums::cases(), 'name')
            )],
        ];
    }
}
