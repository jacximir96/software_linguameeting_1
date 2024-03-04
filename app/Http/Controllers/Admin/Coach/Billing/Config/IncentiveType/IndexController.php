<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;


class IndexController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $types = IncentiveType::orderBy('name')->get();

        $breadcrumb = new IndexBreadcrumb();

        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'types' => $types,
        ]);

        return view('admin.coach.billing.config.incentive-type.index');
    }
}
