<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use App\Src\Shared\Service\ColorFactory;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UserDomain\Role\Service\RoleChecker;
use Spatie\Permission\Models\Role;

class IndexController extends Controller
{
    use Breadcrumable, Orderable;

    private InstructorRepository $instructorRepository;

    private RoleChecker $checkerRole;

    public function __construct(InstructorRepository $instructorRepository, RoleChecker $checkerRole)
    {
        $this->instructorRepository = $instructorRepository;
        $this->checkerRole = $checkerRole;
    }

    public function __invoke()
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('lastname');

        $criteria = new CriteriaSearch($searchForm->model());

        $instructors = $this->instructorRepository->search($criteria, $orderListing, $this->instructorRepository->courseRelationship());

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        $colorFactory = app(ColorFactory::class);

        view()->share([
            'colorFactory' => $colorFactory,
            'instructors' => $instructors,
            'orderListing' => $orderListing,
            'searchForm' => $searchForm,
            'searchTeachignAssistant' => $this->searchTeachingAssistant($criteria),
        ]);

        return view('admin.instructor.index');
    }

    private function searchTeachingAssistant(CriteriaSearch $criteriaSearch): bool
    {

        if (! $criteriaSearch->searchBy('role_id')) {
            return false;
        }

        $role = Role::find($criteriaSearch->get('role_id'));

        if (is_null($role)) {
            return false;
        }

        return $this->checkerRole->isTeachingAssistant($role);

    }
}
