<?php

namespace RedRockDigital\Api\Rules;

use RedRockDigital\Api\Models\User;
use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Class CheckOldPassword
 */
final class ConfirmOldPassword implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        /** @var User $user */
        $user = request()?->user();

        if (Hash::check($value, $user->password) === false) {
            $fail('The current password entered does not match our records.');
        }
    }
}
