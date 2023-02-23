<?php

use RedRockDigital\Api\Jobs\StripeWebhooks\InvoicePaymentFailedJob;

return [
    'invoice.payment_failed' => InvoicePaymentFailedJob::class
];