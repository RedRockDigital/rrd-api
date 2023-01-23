<?php

use Illuminate\Validation\Rules\Password;

return [
    'support_email' => env('BASE_SUPPORT_EMAIL', 'support@redrockdigital.dev'),

    'auth'          => [
        // Defines the username field used for authing users
        'username'      => 'email',

        // Type of value being held, this is used in request validation. E.g. string or email
        'username_type' => 'email',
    ],

    'passwords'     => [
        // The rules in which users passwords must validate to
        'validation' => Password::min(8)->mixedCase()->numbers(),
    ],

    // Defines a default set of groups and their permissions
    'groups'        => [
        [
            'name'   => 'Owner',
            'ref'    => 'OWNER',
            'scopes' => [
                'team.manage',
                'team.manage-billing',
                'users.create',
                'users.view',
                'dashboard.view',
            ],
        ],
        [
            'name'   => 'User',
            'ref'    => 'USER',
            'scopes' => [
                'dashboard.view',
            ],
        ],
    ],

    // Default group for registration
    'default_group' => 'OWNER',
];
