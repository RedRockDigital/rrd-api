<?php

use RedRockDigital\Api\Services\Payments\Providers\Stripe\Enums\StripeMode;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\StripeService;

return [
    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    | This will tell the system, which Provider to bind to the interface.
    | More providers can be added and adapted at later dates.
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
        | Tier List Quantities
        |--------------------------------------------------------------------------
        | If you're using a QTY based pricing, this will take one price
        | and increment the amount of QTY * cost on the subscription.
        |
        | If the QUANTITY is active, please set each tier against a number qty.
        | If the KEYS is active, please set each tier against a price key from the provider.
        */
        'tiers' => [
            'FREE'     => [
                'name'       => 'Free',
                'key'        => 'price_1MOn6uKkXCnLx7Bwb3N7syQW',
                'quantity'   => null,
                'price'      => 0,
                'allowances' => [
                    'submissions' => 50,
                ],
            ],
            'PERSONAL' => [
                'name'       => 'Personal',
                'key'        => 'price_1LyCWTKkXCnLx7BwnpePTeiN',
                'quantity'   => null,
                'price'      => 5,
                'allowances' => [
                    'submissions' => 100,
                ],
            ],
            'SMALL'    => [
                'name'       => 'Small',
                'key'        => 'price_1MDGSKKkXCnLx7Bw4JrGAlyb',
                'quantity'   => null,
                'price'      => 10,
                'allowances' => [
                    'submissions' => 200,
                ],
            ],
            'GROWTH'   => [
                'name'       => 'Growth',
                'key'        => 'price_1MQT33KkXCnLx7BwnMufHc0l',
                'quantity'   => null,
                'price'      => 15,
                'allowances' => [
                    'submissions' => 300,
                ],
            ],
        ],
    ],
];
