<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class FileExists implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return Storage::disk('s3')->exists($value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('validation.file_key_invalid');
    }
}
