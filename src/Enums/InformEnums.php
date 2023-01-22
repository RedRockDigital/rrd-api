<?php

namespace App\Enums;

enum InformEnums: string
{
    case RECEIVE_PROMOTIONAL = 'Promotional Materials';

    /**
     * @param  string  $name
     * @return InformEnums|null
     */
    public static function fromName(string $name): ?InformEnums
    {
        foreach (self::cases() as $informables) {
            if ($name === $informables->name) {
                return $informables;
            }
        }

        return null;
    }
}
