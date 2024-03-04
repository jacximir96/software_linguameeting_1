<?php
namespace App\Http\Controllers\Instructor\Course\Gradebook;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\StudentsTablePresenter;
use App\Src\CourseDomain\SessionDomain\Session\Request\FilterStudentsByCourseRequest;
use App\Src\CourseDomain\SessionDomain\StudentReview\Export\GradeBookExcel;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelClass;


class DownloadGradebookFileController extends Controller
{

    public function __invoke(string $filename)
    {

        try{

            $pathinfo = pathinfo($filename);
            $filenameDownload = 'gradebook.'.$pathinfo['extension'];

            $path = storage_path('app/public/gradebook/'.$filename);

            return response()->download($path, $filenameDownload);

        }
        catch (\Throwable $exception){

            Log::error('There is an error when downloading gradebook file.', [
                'filename' => $filename,
                'exception' => $exception,
            ]);

            flash('Error descargando archivo.')->error();

            return back();

        }


    }
}
