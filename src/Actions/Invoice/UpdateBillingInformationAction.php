<?php

namespace App\Actions\Invoice;

use App\Models\Team;

/**
 * Final UpdateBillingInformationAction
 */
final class UpdateBillingInformationAction
{
    /**
     * @param Team|null   $team
     * @param string|null $billingInformation
     *
     * @return void
     */
    public function __invoke(Team $team = null, ?string $billingInformation = null): void
    {
        $team = $team ?? team();

        $team->updateQuietly([
            'billing_information' => $billingInformation,
        ]);
    }
}
