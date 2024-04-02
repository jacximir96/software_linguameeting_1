<?php
namespace App\Http\Controllers\Instructor\Course\Active;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Http\Controllers\Admin\Instructor\Presentable;
use App\Http\Models\SemesterModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    use Breadcrumable, Presentable;
    
    private RoleChecker $checkerRole;

    public function __construct (RoleChecker $checkerRole){
        
        $this->checkerRole = $checkerRole;

    }


    public function __invoke(Int $course_id=0)
    {

        $instructor = user();
        
        $presenter = $this->obtainPresenter($this->checkerRole, $instructor->rol());
        $data = $presenter->handle($instructor, $course_id);
        
        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $semesters = SemesterModel::select('id','name')->get();

        $today = Carbon::now();
        $arrayYears = array($today->year, $today->year + 1);

        $denyIds = DB::table('deny_access_course')
        ->where('user_id', $instructor->id)
        ->pluck('course_id')
        ->toArray();

        $sections = $data->commonResponse()->sections()->whereNotIn('course_id', $denyIds);

        view()->share([
            'checkerRole' => $this->checkerRole,
            'data' => $data,
            'courseSelected' => $course_id,
            'semesters' => $semesters,
            'arrayYears' => $arrayYears,
            'sections' => $sections,
        ]);
        
        return view('instructor.course.active.index');
    }
}
