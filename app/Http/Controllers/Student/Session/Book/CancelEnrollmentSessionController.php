<?php
namespace App\Http\Controllers\Student\Session\Book;


use App\Http\Controllers\Controller;
use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\CancelEnrollmentSessionAction;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Exception\HourLimitExceeded;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsPast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;


class CancelEnrollmentSessionController extends Controller
{

    public function __invoke(EnrollmentSession $enrollmentSession)
    {
        try {

            $enrollment = $enrollmentSession->enrollment;

            DB::beginTransaction();

            $this->registerActivity($enrollmentSession);

            $action = app(CancelEnrollmentSessionAction::class);
            $action->handle($enrollmentSession, user());

            DB::commit();

            flash('La sessión ha sido cancelada correctamente.')->success();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (SessionIsPast $exception) {

            DB::rollback();

            flash('No se puede eliminar una sesión que ya está finalizada.')->error();

            return back()->withInput();
        }
        catch (HourLimitExceeded $hourLimitExceeded){

            DB::rollback();

            $hours = config('linguameeting.course.session.hours_limit.cancel');

            flash(sprintf('No se puede cancelar una sesión cuando faltan menos de %s horas para su comienzo.', $hours))->error();

            return back()->withInput();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when cancel book session.', [
                'enrollmentSession' => $enrollmentSession,
                'exception' => $exception,
            ]);

            flash('Error cancelando la sessión.')->error();

            return back()->withInput();
        }
    }

    private function registerActivity(EnrollmentSession $enrollmentSession): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollmentSession($enrollmentSession)->buildProperty('enrollment_session', 'Enrollment'),
        );

        return activity()
            ->causedBy(user())
            ->performedOn($enrollmentSession)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.sessions.cancel'));
    }
}
