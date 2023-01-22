<?php

namespace RedRockDigital\Api\Http\Requests;

use RedRockDigital\Api\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class VerifyEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $user = User::findOrFail($this->get('user'));

        return $user?->authoriseVerification((string) $this->get('token'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = User::findOrFail($this->get('user'));

        return $user->is_setup ? [] : [
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name'  => [
                'required',
                'string',
                'max:255',
            ],
            'password'   => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ];
    }
}
