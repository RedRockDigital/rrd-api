<?php

namespace App\Actions\Invoice;

use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Laravel\Cashier\Invoice;

/**
 * Final RenderInvoiceAction
 */
final class RenderInvoiceAction
{
    /**
     * @param Team|null $team
     * @param string|null $id
     * @return Response
     */
    public function __invoke(Team $team = null, string $id = null): Response
    {
        return $this->view(
            team: $team,
            invoice: $team->findInvoice($id)
        )->stream();
    }

    /**
     * @param Team $team
     * @param Invoice $invoice
     * @return \Barryvdh\DomPDF\PDF
     */
    private function view(Team $team, Invoice $invoice): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('receipt', array_merge($invoice->toArray(), [
            'invoice' => $invoice,
            'team'    => $team,
        ]));
    }
}
