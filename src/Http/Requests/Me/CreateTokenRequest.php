<?php

namespace App\Http\Requests\Me;

use Illuminate\Foundation\Http\FormRequest;

class CreateTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|max:191',
            'expiration' => 'required|string',
        ];
    }
}
