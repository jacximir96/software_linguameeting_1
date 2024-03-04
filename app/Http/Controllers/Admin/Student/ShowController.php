<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\StudentDomain\Student\Presenter\ShowStudentPresenter;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;

class ShowController extends Controller
{
    use Breadcrumable;

    private RoleChecker $checkerRole;

    public function __construct(RoleChecker $checkerRole)
    {

        $this->checkerRole = $checkerRole;
    }

    public function __invoke(User $student)
    {
        $this->buildBreadcrumbAndSendToView(ShowBreadcrumb::SLUG);

        $query = app(ShowStudentPresenter::class);
        $viewData = $query->handle($student);

        view()->share([
            'student' => $student,
            'viewData' => $viewData,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.student.show');
    }
}
