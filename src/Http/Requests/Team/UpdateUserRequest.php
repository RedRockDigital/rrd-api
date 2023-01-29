<?php

namespace RedRockDigital\Api\Http\Requests\Team;

use RedRockDigital\Api\Rules\CheckGroupCanBeUpdated;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'group_id' => [
                'required',
                'uuid',
                Rule::exists('groups', 'id'),
                new CheckGroupCanBeUpdated(),
            ],
        ];
    }
}
