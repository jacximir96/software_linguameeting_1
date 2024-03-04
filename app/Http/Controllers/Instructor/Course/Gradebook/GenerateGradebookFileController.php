<?php
namespace App\Http\Controllers\Instructor\Course\Gradebook;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\StudentsTablePresenter;
use App\Src\CourseDomain\SessionDomain\Session\Request\FilterStudentsByCourseRequest;
use App\Src\CourseDomain\SessionDomain\StudentReview\Export\GradeBookCanva;
use App\Src\CourseDomain\SessionDomain\StudentReview\Export\GradeBookExcel;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelClass;


class GenerateGradebookFileController extends Controller
{

    public function __invoke(FilterStudentsByCourseRequest $request)
    {

        try{

            $studentFilter = $request->studentsFilter();

            $presenter = app(StudentsTablePresenter::class);
            $viewData = $presenter->handle($studentFilter);

            $students = $viewData->students()->get();

            $searchForm = app(SearchForm::class);
            $searchForm->config();

            $instructor = user();
            $maxSessions = $viewData->students()->maxSessions();

            $filename = (string)user()->id.Str::random(10);

            if ($request->filetype == 'for_excel'){

                $filename = $filename.'.xlsx';

                $result = Excel::store(new GradeBookExcel($instructor, $maxSessions, $students ), $filename, 'gradebook', ExcelClass::XLSX);

                if ($result){
                    return $filename;
                }
            }
            elseif ($request->filetype == 'for_csv'){

                $filename = $filename.'.csv';

                $result = Excel::store(new GradeBookExcel($instructor, $maxSessions, $students ), $filename, 'gradebook', ExcelClass::CSV);

                if ($result){
                    return $filename;
                }
            }
            elseif ($request->filetype == 'for_canva'){

                $filename = $filename.'_canva.xlsx';

                $result = Excel::store(new GradeBookCanva($instructor, $maxSessions, $students ), $filename, 'gradebook', ExcelClass::XLSX);

                if ($result){
                    return $filename;
                }
            }
            elseif ($request->filetype == 'for_html'){

                view()->share([
                    'instructor' => user(),
                    'maxSessions' => $maxSessions,
                    'students' => $students
                ]);

                return view('instructor.course.gradebook.html_format');
            }
            return 'adiós';

            return '';

        }
        catch (\Throwable $exception){

            Log::error('There is an error when generating gradebook file.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash('There is an error when generating gradebook file.')->error();

            return back();
        }
    }
}
