<?php

use RedRockDigital\Api\Jobs\StripeWebhooks\SubscriptionUpdatedJob;

return [
    'stripe' => [
        'customer.subscription.updated' => SubscriptionUpdatedJob::class,
        'customer.subscription.created' => SubscriptionUpdatedJob::class,
    ]
];