<?php

use RedRockDigital\Api\Jobs\StripeWebhooks\SubscriptionUpdated;

return [
    'stripe' => [
        'subscription.updated' => SubscriptionUpdated::class,
    ]
];