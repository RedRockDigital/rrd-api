<?php

namespace RedRockDigital\Api\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            config('base.auth.username') => [
                'required',
                config('base.auth.username_type'),
            ],
        ];
    }
}
