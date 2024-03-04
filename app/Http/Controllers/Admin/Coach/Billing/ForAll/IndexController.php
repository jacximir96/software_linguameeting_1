<?php

namespace App\Http\Controllers\Admin\Coach\Billing\ForAll;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForAllForm;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForOneForm;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;

//Index for all coaches
class IndexController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $form = app(SearchBillingForAllForm::class);
        $form->configFromRequest();

        view()->share([
            'form' => $form,
        ]);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $linguaMoney = new LinguaMoney();

        view()->share([
            'linguaMoney' => $linguaMoney,
        ]);

        return view('admin.coach.billing.for-all.index');
    }
}
