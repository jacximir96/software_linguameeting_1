<?php
namespace App\Http\Controllers\Student\Session\ExtraSession;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionOrderIsInvalid;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Presenter\Breadcrumb\UseExtraSessionBreadcrumb;
use App\Src\StudentRole\BookSession\Request\SearchCoachRequest;
use App\Src\StudentRole\BookSession\Service\SelectExtraSessionFlexForm;
use App\Src\StudentRole\Coach\Presenter\BookSessionCoachPresenter;
use Illuminate\Support\Facades\Log;


/**
 * Mostrar las opciones de horas disponibles por un coach dentro de un tramo horario
 * Class ShowCoachController
 * @package App\Http\Controllers\Student\Session\Book
 */
class ShowCoachController extends Controller
{

    use Breadcrumable, ExtraSessionable;

    public function showCoachFromUri(Enrollment $enrollment, int $sessionOrder)
    {

        $this->checkSessionOrderIsValid($enrollment, $sessionOrder);

        $request = app(SearchCoachRequest::class);
        $request->merge(request()->all());

        return $this->process($request, $enrollment, $sessionOrder);
    }


    public function showCoachFromPost(SearchCoachRequest $request, Enrollment $enrollment, int $sessionOrder)
    {
        try{
            $this->checkSessionOrderIsValid($enrollment, $sessionOrder);
        }
        catch (SessionOrderIsInvalid $exception){

            flash('Session order parameter is incorrect.')->error();
            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }


        return $this->process($request, $enrollment, $sessionOrder);
    }

    private function process (SearchCoachRequest $request, Enrollment $enrollment, int $sessionOrder){

        try {

            $this->checkSessionOrderIsValid($enrollment, $sessionOrder);

            $sessionOrder = new SessionOrder($sessionOrder);

            $breadcrumb = new UseExtraSessionBreadcrumb($enrollment);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $presenter = app(BookSessionCoachPresenter::class);
            $viewData = $presenter->handle($request, $enrollment);

            $selectSessionForm = app(SelectExtraSessionFlexForm::class, [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
            ]);

            view()->share([
                'course' => $enrollment->course(),
                'enrollment' => $enrollment,
                'selectSessionForm' => $selectSessionForm,
                'sessionOrder' => $sessionOrder,
                'studentTimezone' => $this->userTimezone(),
                'viewData' => $viewData
            ]);

            return view('student.enrollment.session.book.show_availability_coach');

        }
        catch (SessionOrderIsInvalid $exception){

            flash('Session order parameter is incorrect.')->error();
            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (\Throwable $exception) {

            Log::error('There is an error when show coach availability.', [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'exception' => $exception,
            ]);

            flash('Se produjo un erro al mostrar la disponibilidad del coach.')->error();

            return back()->withInput();
        }
    }
}
