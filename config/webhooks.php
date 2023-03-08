<?php

use RedRockDigital\Api\Jobs\StripeWebhooks\{
    SubscriptionUpdatedJob,
    SubscriptionDeletedJob,
    InvoicePaymentFailedJob
};

return [
    'stripe' => [
        'customer.subscription.updated' => SubscriptionUpdatedJob::class,
        'customer.subscription.created' => SubscriptionUpdatedJob::class,
        'customer.subscription.deleted' => SubscriptionDeletedJob::class,
        'invoice.payment_failed'        => InvoicePaymentFailedJob::class
    ]
];