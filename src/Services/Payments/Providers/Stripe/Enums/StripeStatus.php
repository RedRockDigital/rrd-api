<?php

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe\Enums;

enum StripeStatus: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
    case PAST_DUE = 'past_due';
}
