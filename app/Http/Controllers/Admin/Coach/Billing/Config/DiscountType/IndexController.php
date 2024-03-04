<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;


class IndexController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $types = DiscountType::orderBy('name')->get();

        $breadcrumb = new IndexBreadcrumb();

        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'types' => $types,
        ]);

        return view('admin.coach.billing.config.discount-type.index');
    }
}
