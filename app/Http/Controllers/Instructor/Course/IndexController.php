<?php
namespace App\Http\Controllers\Instructor\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Http\Models\SemesterModel;
use Carbon\Carbon;
use App\Http\Controllers\Admin\Instructor\Presentable;


class IndexController extends Controller
{
    use Breadcrumable, Presentable;

    private RoleChecker $checkerRole;

    public function __construct (RoleChecker $checkerRole){

        $this->checkerRole = $checkerRole;
        
    }


    public function __invoke()
    {
        $instructor = user();

        $presenter = $this->obtainPresenter($this->checkerRole, $instructor->rol());
        $data = $presenter->handle($instructor);

        $semesters = SemesterModel::select('id','name')->get();

        $today = Carbon::now();
        $arrayYears = array($today->year, $today->year + 1);

        
        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'checkerRole' => $this->checkerRole,
            'semesters' => $semesters,
            'data' => $data,
            'arrayYears' => $arrayYears
        ]);
        
        return view('instructor.course.index');
    }
}
