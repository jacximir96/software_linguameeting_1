<?php
namespace App\Http\Controllers\Instructor\Admin;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;



class IndexController extends Controller
{
    use Breadcrumable;

    private InstructorRepository $instructorRepository;

    public function __construct (InstructorRepository $instructorRepository) {
        $this->instructorRepository = $instructorRepository;
    }


    public function __invoke()
    {
        $instructor = user();
        $ids = [3,4,5,6];

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $university = $this->instructorRepository->obtainUniversityByUser($instructor);
        $instructors =  $this->instructorRepository->obtainInstructorByUniversityForIndex($university,$instructor,$ids);

        view()->share([
            'instructors' => $instructors,
        ]);

        return view('instructor.admin.index');
    }
}
