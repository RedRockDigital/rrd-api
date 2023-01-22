<?php

namespace App\Services\Payments\Providers\Stripe\Enums;

enum StripeStatus: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
}
