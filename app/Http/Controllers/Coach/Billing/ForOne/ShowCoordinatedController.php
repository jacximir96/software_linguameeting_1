<?php
namespace App\Http\Controllers\Coach\Billing\ForOne;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingPayerPresenter;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;


class ShowCoordinatedController extends Controller
{

    public function __invoke(User $coach, int $month, int $year)
    {

        $month = new Month($month, $year);

        $presenter = app(BillingPayerPresenter::class);
        $viewData = $presenter->handle($month, $coach);

        $linguaMoney = new LinguaMoney();

        view()->share([
            'coach' => $coach,
            'linguaMoney' => $linguaMoney,
            'viewData' => $viewData,
        ]);

        return view('admin.coach.billing.for-one.coordinated_index');
    }
}
