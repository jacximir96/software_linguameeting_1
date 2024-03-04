<?php
namespace App\Http\Controllers\Coach\Billing\ForOne;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingPayerPresenter;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingIndividualPresenter;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForOneForm;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class ShowFilteredController extends Controller
{

    public function __invoke(User $coach, int $month, int $year)
    {
        try {

            $month = new Month($month, $year);

            $form = app(SearchBillingForOneForm::class);
            $form->config($coach);

            if ($coach->coachInfo->isPayer()){
                $presenter = app(BillingPayerPresenter::class);
                $viewData = $presenter->handle($month, $coach);
            }
            else{
                $presenter = app(BillingIndividualPresenter::class);
                $viewData = $presenter->handle($month, $coach);
            }

            $linguaMoney = new LinguaMoney();

            view()->share([
                'coach' => $coach,
                'form' => $form,
                'linguaMoney' => $linguaMoney,
                'month' => $month,
                'viewData' => $viewData,
            ]);

            return view('admin.coach.billing.for-one.show_filtered');

        } catch (\Throwable $exception) {

            Log::error('There is an error when show salary.', [
                'coach' => $coach,
                'month' => $month,
                'year' => $year,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.salary.error.on_show'))->error();

            return back()->withInput();
        }
    }
}
