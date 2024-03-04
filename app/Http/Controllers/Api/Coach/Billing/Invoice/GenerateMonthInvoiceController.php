<?php
namespace App\Http\Controllers\Api\Coach\Billing\Invoice;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Action\GenerateInvoiceAction;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\CoachHasNotPaymentInfo;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\InvoiceAlreadyExistsForTheMonth;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\SearchBillingPresenter;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use Illuminate\Support\Facades\DB;


class GenerateMonthInvoiceController extends Controller
{

    private InvoiceRepository $invoiceRepository;

    private LinguaMoney $linguaMoney;


    public function __construct (InvoiceRepository $invoiceRepository, LinguaMoney $linguaMoney){
        $this->invoiceRepository = $invoiceRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function __invoke(int $month, int $year)
    {
        try{

            DB::beginTransaction();

            $month = new Month($month, $year);

            $presenter = app(SearchBillingPresenter::class);
            $viewData = $presenter->handle($month);

            foreach ($viewData->billingSorted() as $billingResponse){

                try{
                    $action = app(GenerateInvoiceAction::class);
                    $action->handle($billingResponse);
                }
                catch (CoachHasNotPaymentInfo $exception){
                    continue;
                }
                catch (InvoiceAlreadyExistsForTheMonth $exception){
                    continue;
                }
            }

            DB::commit();

            session()->flash('invoicesGeneratedSuccessfully', 'true');

            return response('Invoices created successfully', 200);

        }
        catch (\Throwable $exception){

            DB::rollback();

            return response('Error while creating invoices ', 500);
        }
    }
}
