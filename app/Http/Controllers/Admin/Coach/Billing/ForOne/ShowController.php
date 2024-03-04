<?php

namespace App\Http\Controllers\Admin\Coach\Billing\ForOne;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb\CoachBillingBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;


class ShowController extends Controller
{
    use Breadcrumable;

    public function __invoke(User $coach)
    {

        $coach->load('salary', 'incentive', 'incentive.type', 'incentive.frequency', 'discount', 'discount.type');

        $breadcrumb = new CoachBillingBreadcrumb($coach);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $linguaMoney = new LinguaMoney();

        view()->share([
            'coach' => $coach,
            'linguaMoney' => $linguaMoney,
        ]);

        return view('admin.coach.billing.for-one.card_index');
    }
}
