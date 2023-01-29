<?php

namespace RedRockDigital\Api\Http\Controllers\Billing;

use RedRockDigital\Api\Actions\Invoice\{
    RenderInvoiceAction,
    UpdateBillingInformationAction
};
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Billing\InvoiceUpdateRequest;
use RedRockDigital\Api\Http\Resources\Billing\InvoiceResource;
use RedRockDigital\Api\Services\Payments\Payments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Final Class InvoiceController
 */
final class InvoiceController extends Controller
{
    /**
     * @var array
     */
    public array $scopes = [
        'billing.invoices.index'  => 'team.manage-billing',
        'billing.invoices.show'   => 'team.manage-billing',
        'billing.invoices.update' => 'team.manage-billing',
    ];

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this
            ->response
            ->respond(InvoiceResource::collection(Payments::getInvoices(team())));
    }

    /**
     * @param  string  $invoice
     * @param  RenderInvoiceAction  $renderInvoiceAction
     * @return Response
     */
    public function show(string $invoice, RenderInvoiceAction $renderInvoiceAction): Response
    {
        return $renderInvoiceAction(
            team: team(),
            id:   $invoice
        );
    }

    /**
     * @param  InvoiceUpdateRequest  $request
     * @param  UpdateBillingInformationAction  $updateBillingInformationAction
     * @return JsonResponse
     */
    public function update(
        InvoiceUpdateRequest $request,
        UpdateBillingInformationAction $updateBillingInformationAction
    ): JsonResponse {
        $updateBillingInformationAction(
            billingInformation: $request->billing_information
        );

        return $this
            ->response
            ->respond(['message' => __('payments.invoice.update')]);
    }
}
