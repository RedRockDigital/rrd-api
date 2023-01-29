<?php

return [
    'support_email' => env('BASE_SUPPORT_EMAIL', 'support@redrockdigital.dev'),

    'auth'          => [
        // Defines the username field used for authing users
        'username'      => 'email',

        // Type of value being held, this is used in request validation. E.g. string or email
        'username_type' => 'email',
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

    'security_headers' => [
        'X-Frame-Options' => 'SAMEORIGIN',
        'Strict-Transport-Security' => 'max-age=31536000; preload',
        'X-Content-Type-Options' => 'nosniff',
        'X-XSS-Protection' => '1; mode=block',
        'Permissions-Policy' => 'accelerometer=(), ambient-light-sensor=(), autoplay=(), battery=(), camera=(), cross-origin-isolated=(), display-capture=(), document-domain=(), encrypted-media=(), execution-while-not-rendered=(), execution-while-out-of-viewport=(), fullscreen=(), geolocation=(), gyroscope=(), keyboard-map=(), magnetometer=(), microphone=(), midi=(), navigation-override=(), payment=(), picture-in-picture=(), publickey-credentials-get=(), screen-wake-lock=(), sync-xhr=(), usb=(), web-share=(), xr-spatial-tracking=()',
    ],
];
