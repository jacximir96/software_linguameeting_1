<?php
namespace App\Http\Controllers\Student\Survey;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentSurvey\Action\TakeDefaultSurveyAction;
use App\Src\StudentDomain\EnrollmentSurvey\Action\TakeSurveyAction;
use App\Src\Survey\Model\Survey;
use Illuminate\Support\Facades\Log;


class TakeSurveyController extends Controller
{
    use Breadcrumable;


    public function takeDefault (Enrollment $enrollment){

        try{

            $action = app(TakeDefaultSurveyAction::class);
            $action->handle($enrollment);

            return redirect()->to(config('linguameeting.survey.default.url'));
        }
        catch (\Throwable $exception){

            Log::error('Error redirecting to default survey', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash('Error redirecting to survey. Please contact with admin.');

            return back();

        }
    }

    public function takeSurvey (Enrollment $enrollment, Survey $survey){

        try{

            $action = app(TakeSurveyAction::class);
            $action->handle($enrollment, $survey);

            return redirect()->to($survey->url);
        }
        catch (\Throwable $exception){

            Log::error('Error redirecting to default survey', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash('Error redirecting to survey. Please contact with admin.');

            return back();

        }
    }
}
