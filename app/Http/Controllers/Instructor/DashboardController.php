<?php
namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Dashboard\Presenter\Breadcrumb\DashboardBreadcrumb;
use App\Src\InstructorDomain\Dashboard\Presenter\DashboardPresenter;


class DashboardController extends Controller
{
    use Breadcrumable, Orderable;

    public function __invoke()
    {
        $instructor = user();
        
        $presenter = app(DashboardPresenter::class);
        $viewData = $presenter->handle($instructor);        
        
        $breadcrumb = new DashboardBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);
        
        view()->share([
            'instructor' => $instructor,
            'timezone' => $this->userTimezone(),
            'viewData' => $viewData,
        ]);

        return view('instructor.dashboard.index');
    }
}
