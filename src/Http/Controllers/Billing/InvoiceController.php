<?php

namespace App\Http\Controllers\Billing;

use App\Actions\Invoice\{
    RenderInvoiceAction,
    UpdateBillingInformationAction
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\InvoiceUpdateRequest;
use App\Http\Resources\Billing\InvoiceResource;
use App\Services\Payments\Payments;
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
        'invoices.index'  => 'billing.invoices.index',
        'invoices.show'   => 'billing.invoices.show',
        'invoices.update' => 'billing.invoices.update',
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
