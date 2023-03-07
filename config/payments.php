<?php

use RedRockDigital\Api\Services\Payments\Providers\Stripe\Enums\StripeMode;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\StripeService;

return [
    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    | This is the active provider that will be used for the payment system.
    */
    'provider'  => StripeService::class,

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    | A full list of all providers that can be used as an adapter for the payment
    | system.
    */
    'providers' => [
        StripeService::class => 'stripe',
    ],

    /*
    |--------------------------------------------------------------------------
    | Provider Specific Settings
    |--------------------------------------------------------------------------
    | Each provider will have their own specific settings which can be utilized
    | inside each provider class.
    |
    | The Mode can be either QUANTITY or KEYS from the amount (qty * cost of subscription).
    | If mode is KEY, it will set the subscription based on the price_key relevant for that tier.
    */
    'stripe'    => [
        'mode'  => StripeMode::KEYS,

        /*
        |--------------------------------------------------------------------------
        | Tier Settings
        |--------------------------------------------------------------------------
        | Below you can define statically, what a user can do based on their tier.
        | This config will drive the system to allow or deny access.
        */
        'tiers' => [
            'FREE'     => [],
            'PERSONAL' => [],
            'SMALL'    => [],
            'GROWTH'   => [],
        ],
    ],
];
