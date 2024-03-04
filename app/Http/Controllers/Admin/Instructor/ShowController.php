<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\DenyAccess\Service\CheckerDenyAccess;
use App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\Shared\Service\ColorFactory;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;

class ShowController extends Controller
{
    use Breadcrumable, Presentable;

    private RoleChecker $checkerRole;

    public function __construct(RoleChecker $checkerRole)
    {

        $this->checkerRole = $checkerRole;
    }

    public function __invoke(User $instructor)
    {
        $presenter = $this->obtainPresenter($this->checkerRole, $instructor->rol());
        $data = $presenter->handle($instructor);

        $this->buildBreadcrumbAndSendToView(ShowBreadcrumb::SLUG);

        $colorFactory = app(ColorFactory::class);
        $checkerDenyAccess = new CheckerDenyAccess($instructor->denyAccess);

        view()->share([
            'checkerDenyAccess' => $checkerDenyAccess,
            'checkerRole' => $this->checkerRole,
            'colorFactory' => $colorFactory,
            'data' => $data,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.instructor.show');
    }
}
