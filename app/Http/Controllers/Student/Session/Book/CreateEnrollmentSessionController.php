<?php
namespace App\Http\Controllers\Student\Session\Book;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Exception\HourLimitExceeded;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsFull;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Exception\EnrollmentDoesntHaveMakeup;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;
use App\Src\StudentDomain\Makeup\Service\MakeupInfoSession;
use App\Src\StudentRole\BookSession\Action\AssociateMakeupWithNotBookedSessionAction;
use App\Src\StudentRole\BookSession\Action\CreateBookSessionAction;
use App\Src\StudentRole\BookSession\Action\AssociateMakeupWithBookedSessionAction;
use App\Src\StudentRole\BookSession\Action\RescheduleSessionAction;
use App\Src\StudentRole\BookSession\Request\CreateSessionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Guardar la sesión escogida por el alumno
 * Class CreateEnrollmentSessionController
 * @package App\Http\Controllers\Student\Session\Book
 */
class CreateEnrollmentSessionController extends Controller
{

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private MakeupRepository $makeupRepository;

    public function __construct(EnrollmentSessionRepository $enrollmentSessionRepository, MakeupRepository $makeupRepository){

        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->makeupRepository = $makeupRepository;
    }

    public function __invoke(CreateSessionRequest $request, Enrollment $enrollment, int $sessionOrder)
    {
        try {

            $sessionOrder = new SessionOrder($sessionOrder);

            DB::beginTransaction();

            $enrollmentSession = $this->enrollmentSessionRepository->obtainByEnrollmentAndSessionOrder($enrollment, $sessionOrder);

            if (session()->has('isMakeup')){

                $this->createFromMakeup($request, $enrollment, $sessionOrder);

                flash(trans('student.enrollment.makeup.create_success'))->success();

            }
            elseif ($enrollmentSession){
                //...ya existe sesión de la matrícula para el sessionOrdr
                $action = app(RescheduleSessionAction::class);
                $action->handle($request, $enrollmentSession);

                flash(trans('student.enrollment.session.create.create_success'))->success();
            }
            else{
                $action = app(CreateBookSessionAction::class);
                $action->handle($request, $enrollment, $sessionOrder);

                flash(trans('student.enrollment.session.create.create_success'))->success();
            }

            DB::commit();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (EnrollmentDoesntHaveMakeup $exception){

            DB::rollback();

            flash('No tienes Makeup disponibles para ser usadas.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollmentSession->enrollment->hashId());

        }
        catch (SessionIsFull $exception){

            DB::rollback();

            flash('No es posible tu inscripción en la sesión ya que esta se encuentra con el aforo completo.')->error();

            $queryString = http_build_query($request->except(['_token']));
            return redirect()->route('get.student.session.book.create.show_coach_full', [$enrollment->hashId(), $sessionOrder->get(), $queryString]);

        }
        catch (HourLimitExceeded $exception){

            DB::rollback();

            flash('Sessions must be scheduled at least 12 hours in advance.')->error();

            $queryString = http_build_query($request->except(['_token']));
            return redirect()->route('get.student.session.book.create.show_coach_full', [$enrollment->hashId(), $sessionOrder->get(), $queryString]);

        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create book session.', [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'exception' => $exception,
            ]);

            flash('Error creando sessión.')->error();

            return back()->withInput();
        }
    }


    private function createFromMakeup(CreateSessionRequest $request, Enrollment $enrollment, SessionOrder $sessionOrder): EnrollmentSession
    {
        $action = app(CreateBookSessionAction::class);
        $newEnrollmentSession = $action->handle($request, $enrollment, $sessionOrder);

        $makeupInfoSession = new MakeupInfoSession(session()->get('isMakeup')); //makeupInfoSession se configuró con la sesión inicial

        if ($makeupInfoSession->isBookedSession()) {

            //..y ahora le asignamos la makeup y la sesión perdida
            $missedEnrollmentSession = $makeupInfoSession->enrollmentSession();

            $action = app(AssociateMakeupWithBookedSessionAction::class);
            $action->handle($newEnrollmentSession, $missedEnrollmentSession);
        }
        else{

            $makeup = $this->makeupRepository->obtainFirstNotUsedByEnrollment($enrollment);

            if (is_null($makeup)){
                throw new EnrollmentDoesntHaveMakeup;
            }

            $action = app(AssociateMakeupWithNotBookedSessionAction::class);
            $action->handle($newEnrollmentSession, $makeup);
        }

        return $newEnrollmentSession;
    }
}
