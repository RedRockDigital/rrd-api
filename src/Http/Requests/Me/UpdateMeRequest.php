<?php

namespace App\Http\Requests\Me;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateMeRequest
 *
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $user_name
 */
class UpdateMeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name'                 => [
                'required',
                'string',
                'max:255',
            ],
            'last_name'                  => [
                'required',
                'string',
                'max:255',
            ],
            config('base.auth.username') => [
                'required',
                config('base.auth.username_type'),
                Rule::unique('users', config('base.auth.username'))->ignore($this->user()->id),
                'max:255',
            ],
        ];
    }
}
