<?php
namespace App\Http\Controllers\Student\Session\ExtraSession;


use App\Http\Controllers\Controller;
use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Exception\HourLimitExceeded;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsFull;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionOrderIsInvalid;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentDoesntExtraSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;
use App\Src\StudentRole\BookSession\Action\CreateExtraSessionAction;
use App\Src\StudentRole\BookSession\Request\CreateSessionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;


/**
 * Guardar la sesión escogida por el alumno
 * Class CreateEnrollmentSessionController
 * @package App\Http\Controllers\Student\Session\Book
 */
class CreateEnrollmentSessionController extends Controller
{
    use ExtraSessionable;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private MakeupRepository $makeupRepository;

    public function __construct(EnrollmentSessionRepository $enrollmentSessionRepository, MakeupRepository $makeupRepository){

        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->makeupRepository = $makeupRepository;
    }

    public function __invoke(CreateSessionRequest $request, Enrollment $enrollment, int $sessionOrder)
    {
        try {

            $this->checkSessionOrderIsValid($enrollment, $sessionOrder);

            $sessionOrder = new SessionOrder($sessionOrder);

            DB::beginTransaction();

            $action = app(CreateExtraSessionAction::class);
            $enrollmentSession = $action->handle($request, $enrollment, $sessionOrder);

            $this->registerActivity($enrollmentSession);

            DB::commit();

            flash(trans('student.enrollment.session.extra-session.create.create_success'))->success();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (SessionOrderIsInvalid $exception){

            flash('Session order parameter is incorrect.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (EnrollmentDoesntExtraSession $exception){

            DB::rollback();

            flash('No tienes extra session disponible para ser utilizada.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

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

    private function registerActivity (EnrollmentSession $enrollmentSession):Activity{

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollmentSession($enrollmentSession)->buildProperty('enrollment_session', 'Session')
        );

        return activity()
            ->causedBy(user())
            ->performedOn($enrollmentSession)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.sessions.extra_session'));
    }
}
