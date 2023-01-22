<?php

namespace RedRockDigital\Api\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => [
                'required',
                'email',
            ],
            'group_id' => [
                'required',
                'uuid',
                Rule::exists('groups', 'id'),
            ],
        ];
    }
}
