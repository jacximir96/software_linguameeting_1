<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Invoice;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Action\GenerateInvoiceAction;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\CoachHasNotPaymentInfo;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Service\GenerateInvoiceRequest;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingIndividualPresenter;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingPayerPresenter;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateAndDownloadInvoiceController extends Controller
{

    private InvoiceRepository $invoiceRepository;

    private LinguaMoney $linguaMoney;


    public function __construct (InvoiceRepository $invoiceRepository, LinguaMoney $linguaMoney){
        $this->invoiceRepository = $invoiceRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function fromRequest(GenerateInvoiceRequest $request, User $coach)
    {
        return $this->proccessRequest($coach, $request->month());
    }

    public function fromUrlParameters(User $coach, int $month, int $year)
    {
        $month = new Month($month, $year);

        return $this->proccessRequest($coach, $month);
    }


    //private...
    private function proccessRequest (User $coach, Month $month){

        try{

            $invoice = $this->invoiceRepository->obtainByCoachAndMonth($coach, $month);

            if ($invoice){
                return $this->download($invoice);
            }

            $invoice = $this->obtainInvoice($coach, $month);

            return $this->download($invoice);

        }
        catch (\Throwable $exception){

            flash(trans('coach.billing.incentive.error.on_create'))->error();

            return back()->withInput();
        }
    }

    private function obtainInvoice (User $coach, Month $month):Invoice{

        try {

            DB::beginTransaction();

            if ($coach->coachInfo->isPayer()){
                $presenter = app(BillingPayerPresenter::class);
                $billingResponse = $presenter->handle($month, $coach);
            }
            else{
                $presenter = app(BillingIndividualPresenter::class);
                $billingResponse = $presenter->handle($month, $coach);
            }

            $action = app(GenerateInvoiceAction::class);
            $invoice = $action->handle($billingResponse);

            DB::commit();

            return $invoice;

        }
        catch (CoachHasNotPaymentInfo $exception){

            flash(trans('coach.billing.info.error.not_has_info'))->error();

            return back();

        }
        catch (\Throwable $exception) {

            Log::error('There is an error when generating invoice to coach.', [
                'coach' => $coach,
                'month' => $month,
                'exception' => $exception,
            ]);

            throw new $exception;
        }
    }

    private function download (Invoice $invoice){

        $pdf = PDF::loadView('admin.coach.billing.config.invoice.pdf.index', ['invoice' => $invoice, 'linguaMoney' => $this->linguaMoney]);

        return $pdf->download($invoice->filename());
    }
}
