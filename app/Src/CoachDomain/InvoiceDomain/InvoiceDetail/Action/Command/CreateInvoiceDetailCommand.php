<?php

namespace App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Action\Command;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Model\InvoiceDetail;
use App\Src\Shared\Model\ValueObject\InvoiceDetailQuantity;
use Money\Money;

class CreateInvoiceDetailCommand
{
    public function handle(Invoice $invoice, InvoiceDetailQuantity $quantity, Money $unitPrice, string $description, bool $isPayerDetail = false): InvoiceDetail
    {

        $detail = new InvoiceDetail();
        $detail->invoice_id = $invoice->id;
        $detail->quantity = $quantity->get();
        $detail->unit_price = $unitPrice;
        $detail->description = $description;
        $detail->is_payer = $isPayerDetail;

        $detail->save();

        return $detail;
    }
}
