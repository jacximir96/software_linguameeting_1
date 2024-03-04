<?php
namespace App\Http\Controllers\Admin\Coach\Billing\ForAll;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\SearchBillingPresenter;
use App\Src\CoachDomain\SalaryDomain\Billing\Request\SearchBillingForlAllRequest;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForAllForm;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;


//search and filter for all coaches
class SearchController extends Controller
{
    use Breadcrumable;

    public function fromRequest(SearchBillingForlAllRequest $request)
    {
        try{

            $month = $request->month();

            $form = app(SearchBillingForAllForm::class);
            $form->configFromRequest();

            view()->share('form', $form);

            return $this->proccessRequest($month);
        }
        catch (\Throwable $exception){

        }
    }


    public function fromUrl(int $month, int $year)
    {
        $month = new Month($month, $year);

        $form = app(SearchBillingForAllForm::class);
        $form->configFromMonth($month);

        view()->share('form', $form);

        return $this->proccessRequest($month);

    }

    private function proccessRequest (Month $month){


        try{

            $presenter = app(SearchBillingPresenter::class);
            $viewData = $presenter->handle($month);

            $breadcrumb = new IndexBreadcrumb();
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $linguaMoney = new LinguaMoney();

            $total = $linguaMoney->buildZero();

            if (session()->has('invoicesGeneratedSuccessfully')){
                //when reload from ajax
                flash('Invoices created successfully')->success();
            }

            view()->share([
                'linguaMoney' => $linguaMoney,
                'month' => $month,
                'total' => $total,
                'viewData' => $viewData,
            ]);

            return view('admin.coach.billing.for-all.index');

        }
        catch (\Throwable $exception){

        }

    }
}
