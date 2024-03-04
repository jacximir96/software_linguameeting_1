<?php
namespace App\Http\Controllers\Instructor\Course\Gradebook;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\DashboardGradebookPresenter;
use App\Src\InstructorDomain\Gradebook\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;

class IndexController extends Controller
{
    use Breadcrumable;

    public function __construct (){

    }

    public function __invoke()
    {

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $presenter = app(DashboardGradebookPresenter::class);
        $viewData = $presenter->handle(user());

        view()->share([
            'instructor' => user(),
            'viewData' => $viewData
        ]);

        return view('instructor.course.gradebook.index');
    }
}
