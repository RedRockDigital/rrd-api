<?php

namespace RedRockDigital\Api\Http\Resources\Billing;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Laravel\Cashier\Invoice;

/**
 * @mixin Invoice
 */
class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $invoice = $this->asStripeInvoice();

        return [
            'id'           => $invoice->id,
            'amount_paid'  => number_format(($invoice->amount_paid / 100), 2),
            'subscription' => [
                'id' => $invoice->subscription,
            ],
            'routes'       => [
                'download_invoice' => route('billing.invoices.show', $this->id),
            ],
            'created_at'   => date('Y-m-d H:i:s', $invoice->created),
        ];
    }
}
