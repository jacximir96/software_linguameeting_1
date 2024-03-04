<?php
namespace App\Http\Controllers\Student\Calendar\Google;

use App\Http\Controllers\Controller;
use App\Src\StudentRole\GoogleCalendar\Presenter\GenerateGoogleCalendarPresenter;
use App\Src\StudentRole\GoogleCalendar\Request\GenerateGoogleCalendarRequest;
use App\Src\StudentRole\GoogleCalendar\Service\GenerateGoogleCalendarForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class GenerateController extends Controller
{
    public function configView()
    {

        $form = app(GenerateGoogleCalendarForm::class);
        $form->config();

        view()->share([
            'form' => $form,
        ]);

        return view('student.calendar.google.form');
    }

    public function generate(GenerateGoogleCalendarRequest $request)
    {
        try {

            $action = app(GenerateGoogleCalendarPresenter::class);
            $calendar = $action->handle(user(), $request->period());

            $student = user();
            $filename = Str::slug($student->writeFullName().'-google-calendar');

            return response($calendar->get(), 200, [
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="'.$filename.'.ics"',
            ]);

        } catch (\Throwable $exception) {

            Log::error('There is an error when generate google calendar for student', [
                'student' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.calendar.google-calendar.download.error'))->error();

            return back();
        }
    }
}
