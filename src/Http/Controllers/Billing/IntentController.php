<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Services\Payments\Payments;
use Illuminate\Http\JsonResponse;

class IntentController extends Controller
{
    /**
     * @var array
     */
    public array $scopes = [
        'billing.intents.store' => 'team.manage-billing',
    ];

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        return $this->response->created(Payments::generatePaymentToken(team()));
    }
}
