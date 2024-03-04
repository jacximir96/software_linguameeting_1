<?php
namespace App\Http\Controllers\Instructor\Course\Gradebook;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\StudentsTablePresenter;
use App\Src\CourseDomain\SessionDomain\Session\Request\FilterStudentsByCourseRequest;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class ShowTableGradebookController extends Controller
{

    public function __invoke(User $instructor)
    {

        try{

            request()->merge([
                'instructor_id' => $instructor->id,
                'date_from' => request()->get('date_from'),
                'date_to' => request()->get('date_to'),
                'course_selected' => explode(',', request()->get('course_selected')),
            ]);
            $request = app(FilterStudentsByCourseRequest::class);

            $studentFilter = $request->studentsFilter();

            $presenter = app(StudentsTablePresenter::class);
            $viewData = $presenter->handle($studentFilter);

            $students = $viewData->students()->get();

            $searchForm = app(SearchForm::class);
            $searchForm->config();

            $instructor = user();
            $maxSessions = $viewData->students()->maxSessions();

            view()->share([
                'instructor' => user(),
                'maxSessions' => $maxSessions,
                'students' => $students
            ]);

            return view('instructor.course.gradebook.html_format');

        }
        catch (\Throwable $exception){

            Log::error('There is an error when generating gradebook table.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash('There is an error when generating gradebook table.')->error();

            return back();
        }
    }
}
