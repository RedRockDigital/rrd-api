<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class FileValidType implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected array $mimes)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes(mixed $attribute, mixed $value): bool
    {
        return in_array(Storage::disk('s3')->mimeType($value), $this->mimes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.file_invalid_type');
    }
}
