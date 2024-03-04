<?php
namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Dashboard\Presenter\Breadcrumb\DashboardBreadcrumb;
use App\Src\CoachDomain\Dashboard\Presenter\DashboardPresenter;


class DashboardController extends Controller
{
    use Breadcrumable, Orderable;

    public function __invoke()
    {
        $coach = user();

        $presenter = app(DashboardPresenter::class);
        $viewData = $presenter->handle($coach);

        $breadcrumb = new DashboardBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $getEventsUrl = route('get.admin.api.coach.calendar.events.get', []);

        view()->share([
            'coach' => $coach,
            'getEventUrl' => $getEventsUrl,
            'timezone' => $this->userTimezone(),
            'viewData' => $viewData,
        ]);

        return view('coach.dashboard.index');
    }
}
