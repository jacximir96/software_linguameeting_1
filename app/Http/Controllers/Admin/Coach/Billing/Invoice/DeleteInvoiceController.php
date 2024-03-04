<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Invoice;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Action\DeleteInvoiceAction;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\InvoiceIsNotLast;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\SalaryDomain\Incentive\Action\DeleteIncentiveAction;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteInvoiceController extends Controller
{

    public function __invoke(Invoice $invoice)
    {

        try {

            DB::beginTransaction();

            $action = app(DeleteInvoiceAction::class);
            $action->handle($invoice);

            flash(trans('coach.billing.invoice.delete_success'))->success();

            return redirect()->route('get.admin.coach.billing.for_all.search', [$invoice->month()->month(), $invoice->month()->year()]);
        }
        catch (InvoiceIsNotLast $exception){

            flash(trans('coach.billing.invoice.error.on_delete_is_not_last'))->error();

            return redirect()->route('get.admin.coach.billing.for_all.search', [$invoice->month()->month(), $invoice->month()->year()]);
        }
        catch (\Throwable $exception) {

            Log::error('There is an error when deleting invoice.', [
                'invoice' => $invoice,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.invoice.error.on_delete'))->error();

            return redirect()->route('get.admin.coach.billing.for_all.search', [$invoice->month()->month(), $invoice->month()->year()]);
        }
    }
}
