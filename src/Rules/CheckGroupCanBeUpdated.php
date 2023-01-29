<?php

namespace RedRockDigital\Api\Rules;

use RedRockDigital\Api\Models\Group;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckGroupCanBeUpdated implements InvokableRule
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
        $group = Group::find($value);
        $defaultGroup = Group::getDefault();

        if ($group->ref !== $defaultGroup->ref) {
            $check = \team()->users()
                ->where('id', '!=', request()->route('user')->id)
                ->wherePivot('group_id', $defaultGroup->id)
                ->count();

            if ($check === 0) {
                $fail('You cannot remove the only owner');
            }
        }
    }
}
