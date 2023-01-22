<?php

namespace App\Rules;

use App\Models\PasswordReset;
use Illuminate\Contracts\Validation\Rule;

class VerifyUsernameForPasswordReset implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @param  ?string  $token
     * @return void
     */
    public function __construct(protected ?string $token)
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
        if (!$this->token) {
            return false;
        }

        return PasswordReset::where([
            [$attribute, $value],
            ['token', $this->token],
        ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.unable_to_verify_username_for_password_reset');
    }
}
