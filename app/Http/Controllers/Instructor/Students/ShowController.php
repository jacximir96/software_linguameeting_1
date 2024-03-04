<?php
namespace App\Http\Controllers\Instructor\Students;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Students\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\InstructorDomain\Students\Presenter\ShowEnrollmentPresenter;
use App\Src\InstructorDomain\Students\Service\AccommodationForm;
use App\Src\InstructorDomain\Students\Service\ChangeSectionFormForm;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class ShowController extends Controller
{
    use Breadcrumable;

    public function __construct (){

    }

    public function __invoke(Enrollment $enrollment)
    {
        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $presenter = app(ShowEnrollmentPresenter::class);
        $viewData = $presenter->handle($enrollment);

        $accommodationForm = app(AccommodationForm::class);
        $accommodationForm->configForEdit($enrollment);

        $changeSectionForm = app(ChangeSectionFormForm::class);
        $changeSectionForm->config($enrollment);

        view()->share([
            'accommodationForm' => $accommodationForm,
            'changeSectionForm' => $changeSectionForm,
            'enrollment' => $enrollment,
            'student' => $enrollment->user,
            'viewData' => $viewData,
            'timezone' => $this->userTimezone(),
        ]);

        return view('instructor.students.show');
    }
}
