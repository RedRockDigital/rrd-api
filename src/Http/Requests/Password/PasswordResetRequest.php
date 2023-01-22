<?php

namespace App\Http\Requests\Password;

use App\Rules\VerifyUsernameForPasswordReset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PasswordResetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            config('base.auth.username') => [
                'required',
                config('base.auth.username_type'),
                new VerifyUsernameForPasswordReset($this->get('token')),
            ],
            'token'                      => [
                'required',
                'string',
                Rule::exists('password_resets'),
            ],
            'password'                   => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ];
    }
}
