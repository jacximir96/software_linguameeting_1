<?php

namespace App\Http\Controllers\Admin\Coach\Billing\ForOne;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Service\GenerateInvoiceForm;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingPayerPresenter;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingIndividualPresenter;
use App\Src\CoachDomain\SalaryDomain\Billing\Request\ShowBillingRequest;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForOneForm;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class FilterBillingController extends Controller
{

    private InvoiceRepository $invoiceRepository;

    public function __construct (InvoiceRepository $invoiceRepository){

        $this->invoiceRepository = $invoiceRepository;
    }

    public function configView(User $coach)
    {

        $form = app(SearchBillingForOneForm::class);
        $form->config($coach);

        view()->share([
            'coach' => $coach,
            'form' => $form,
        ]);

        return view('admin.coach.billing.for-one.form_search');
    }

    public function filter(ShowBillingRequest $request, User $coach)
    {
        try {

            $form = app(SearchBillingForOneForm::class);
            $form->config($coach);

            $generateInvoiceForm = app(GenerateInvoiceForm::class);
            $generateInvoiceForm->config($coach, $request->month());

            if ($coach->coachInfo->isPayer()){
                $presenter = app(BillingPayerPresenter::class);
                $viewData = $presenter->handle($request->month(), $coach);
            }
            else{
                $presenter = app(BillingIndividualPresenter::class);
                $viewData = $presenter->handle($request->month(), $coach);
            }

            $invoice = $this->invoiceRepository->obtainByCoachAndMonth($coach, $request->month());

            $linguaMoney = new LinguaMoney();

            view()->share([
                'coach' => $coach,
                'form' => $form,
                'generateInvoiceForm' => $generateInvoiceForm,
                'invoice' => $invoice,
                'linguaMoney' => $linguaMoney,
                'month' => $request->month(),
                'viewData' => $viewData,
            ]);

            return view('admin.coach.billing.for-one.form_search');

        } catch (\Throwable $exception) {

            Log::error('There is an error when show salary.', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.salary.error.on_show'))->error();

            return back()->withInput();
        }
    }
}
