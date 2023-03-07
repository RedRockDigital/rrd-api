<?php

namespace RedRockDigital\Api\Services\Payments;

use RedRockDigital\Api\Models\Team;
use Illuminate\Support\Facades\Facade;

/**
 * Class Payments
 *
 * @method static getCustomer(string $id)
 * @method static getAllowances(?Team $team)
 * @method static provider(?string $provider = null)
 * @method static createCustomer(?Team $team)
 * @method static updateCustomer(?Team $team)
 * @method static hasSubscription(?Team $team)
 * @method static getSubscription(?Team $team)
 * @method static increaseSubscription(?Team $team, int $amount)
 * @method static decreaseSubscription(?Team $team, int $amount)
 * @method static changeSubscription(?Team $team, string $tier)
 * @method static getPaymentMethods(?Team $team)
 * @method static addPaymentMethod(?Team $team, string $pm = '')
 * @method static generatePaymentToken(?Team $team)
 * @method static hasPaymentMethod(?Team $team)

 * @method static cancelSubscription(?Team $team)
 * @method static resumeSubscription(?Team $team)
 * @method static getInvoices(?Team $team)
 * @method static downloadInvoice(?Team $team, string $id = null)
 */
final class Payments extends Facade
{
    /**
     * Register the Facade accessor name
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'payments';
    }
}
