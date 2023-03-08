<?php

namespace RedRockDigital\Api\Services\Payments;

use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use Illuminate\Support\Collection;
use Laravel\Cashier\Invoice;

/**
 * PaymentsInterface
 */
interface PaymentsInterface
{
    /**
     * Get the User of the Team who owns the subscription
     *
     * @param Team|null $team
     *
     * @return User
     */
    public function getOwner(?Team $team): User;

    /**
     * Create the Customer from the Owner of the Team
     *
     * @param Team|null $team
     *
     * @return mixed
     */
    public function createCustomer(?Team $team): mixed;

    /**
     * Update the Customer of the Owner of the Team
     *
     * @param Team|null $team
     *
     * @return mixed
     */
    public function updateCustomer(?Team $team): mixed;

    /**
     * Increase the amount of the Subscription
     *
     * @param Team|null $team
     * @param int       $amount
     *
     * @return void
     */
    public function increaseSubscription(?Team $team, int $amount = 1): void;

    /**
     * Decrease the amount of the Subscription
     *
     * @param Team|null $team
     * @param int       $amount
     *
     * @return void
     */
    public function decreaseSubscription(?Team $team, int $amount = 1): void;

    /**
     * Change the amount of the Subscription directly
     *
     * @param Team|null   $team
     * @param string|null $tier
     *
     * @return void
     */
    public function changeSubscription(?Team $team, string $tier = null): void;

    /**
     * Determine if the Team has a current active Subscription
     *
     * @param Team|null $team
     * @param bool      $isActive
     *
     * @return bool
     */
    public function hasSubscription(?Team $team, bool $isActive = false): bool;

    /**
     * Return the current active subscription for the Team
     *
     * @param Team|null $team
     *
     * @return mixed
     */
    public function getSubscription(?Team $team): mixed;

    /**
     * Add a Payment Method for the Team to use for a Subscription
     *
     * @param Team|null $team
     * @param string    $pmId
     *
     * @return bool
     */
    public function addPaymentMethod(?Team $team, string $pmId = ''): bool;

    /**
     * Determine if the current Team has a default/active Payment Method
     *
     * @param Team|null $team
     *
     * @return mixed
     */
    public function hasPaymentMethod(?Team $team): bool;

    /**
     * Fetch and return a list of the Payment Methods the Team has
     *
     * @param Team|null $team
     *
     * @return ?object
     */
    public function getPaymentMethods(?Team $team): ?object;

    /**
     * Cancel the current Subscription for the Team
     *
     * @param Team|null $team
     *
     * @return void
     */
    public function cancelSubscription(?Team $team): void;

    /**
     * Resume the current Subscription for the Team
     *
     * @param Team|null $team
     *
     * @return void
     */
    public function resumeSubscription(?Team $team): void;

    /**
     * Retrieves all invoices for Team
     *
     * @param Team|null $team
     *
     * @return Collection|Invoice[]
     */
    public function getInvoices(?Team $team): Collection|array;

    /**
     * Download a invoice for Team
     *
     * @param Team|null   $team
     * @param string|null $id
     *
     * @return mixed
     */
    public function downloadInvoice(?Team $team, string $id = null): mixed;
}
