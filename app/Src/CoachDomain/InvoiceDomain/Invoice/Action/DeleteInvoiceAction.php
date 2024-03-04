<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Action;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\InvoiceIsNotLast;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;

class DeleteInvoiceAction
{
    private InvoiceRepository $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {

        $this->invoiceRepository = $invoiceRepository;
    }

    public function handle(Invoice $invoice): Invoice
    {

        $this->checkCanBeDeleted($invoice);

        $invoice->detail()->delete();

        $invoice->delete();

        return $invoice;
    }

    private function checkCanBeDeleted(Invoice $invoice)
    {

        $last = $this->invoiceRepository->obtainByCoachAndMonth($invoice->coach, $invoice->month());

        if ($last) {
            if ($invoice->isOlder($last)) {
                throw new InvoiceIsNotLast();
            }
        }
    }
}
