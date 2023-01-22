<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Class RegisterRequest
 *
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $email
 * @property-read string $password
 */
class RegisterRequest extends FormRequest
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
                Rule::unique('users', config('base.auth.username')),
                'max:255',
            ],
            'password'                   => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
            'referral'                   => [
                'nullable',
                'uuid',
            ],
        ];
    }
}
