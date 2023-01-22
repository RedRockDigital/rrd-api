<?php

namespace App\Services\Payments\Providers\Stripe\Enums;

enum StripeMode
{
    case QUANTITY;
    case KEYS;
}
