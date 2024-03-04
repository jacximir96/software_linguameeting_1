<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Invoice;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;


class DownloadInvoiceController extends Controller
{

    public function __invoke(Invoice $invoice)
    {

        try {

            $linguaMoney = new LinguaMoney();
            $pdf = PDF::loadView('admin.coach.billing.config.invoice.pdf.index', ['invoice' => $invoice, 'linguaMoney' => $linguaMoney]);

            //test
            //view()->share(['invoice' => $invoice, 'linguaMoney' => $linguaMoney]);
            //return view('admin.coach.billing.config.invoice.pdf.index');
            //return $pdf->stream($invoice->filename());

            return $pdf->download($invoice->filename());

        } catch (\Throwable $exception) {

            Log::error('There is an error when downloading invoice file.', [
                'invoice' => $invoice,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.invoice.error.on_download'))->error();

            return back()->withInput();
        }
    }
}
