<?php
namespace App\Http\Controllers\Student\Session\Book;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\NextSessionsPresenter;
use Illuminate\Support\Facades\Log;


class SuggestionsNextSessionsController extends Controller
{

    public function showSuggestions(EnrollmentSession $enrollmentSession)
    {
        try {

            $presenter = app(NextSessionsPresenter::class);
            $nextSessions = $presenter->handle($enrollmentSession);

            if ( ! $nextSessions->hasNextSessions()){
                return redirect()->route('get.student.enrollment.show', $enrollmentSession->enrollment);
            }

            view()->share([
                'enrollmentSession' => $enrollmentSession,
                'nextSessions' => $nextSessions,
                'userTimezone' => $this->userTimezone(),
            ]);

            return view( 'student.enrollment.session.book.suggestions_next_book');

        } catch (\Throwable $exception) {

            Log::error('There is an error when show suggestions for next sessions.', [
                'enrollmentSession' => $enrollmentSession,
                'exception' => $exception,
            ]);

            flash()->error();

            return back()->withInput();
        }
    }


}
