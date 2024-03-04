<?php
namespace App\Src\StudentDomain\Enrollment\Service;


use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\SessionRegister;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\SessionsCollection;
use Carbon\Carbon;

/**
 * Construye las 'bolsas' con las sesiones o coaching weeks que van a aparecer en el curso de un estudiante (missed, next, completed, ..
 * Class SessionsBagBuilder
 * @package App\Src\StudentDomain\Enrollment\Service
 */
class SessionsBagBuilder
{

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct (EnrollmentSessionRepository $enrollmentSessionRepository){

        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function buildForWeeks(SessionsCollection $sessionsCollection, SessionRegister $enrollmentSessionsRegister):SessionsWeeksBag{

        $sessionsBag = app(SessionsWeeksBag::class, ['numTotalSessions' => $sessionsCollection->count()]);

        foreach ($sessionsCollection->orderByNumberSession() as $coachingWeek){

            if ($enrollmentSessionsRegister->hasSessionOrder($coachingWeek->sessionOrderObject())){
                //cuando la coachingWeek tiene un enrollment sesión asociad

                $enrollmentSession = $enrollmentSessionsRegister->filterByOrderWithoutMakeup($coachingWeek->sessionOrderObject());

                if ($enrollmentSession->isExtraSession()){
                    continue; //se procesan después de este foreach
                }

                //missed (estado perdida o (estado no atendida y sesión finalizada)
                if ($enrollmentSession->status->isMissed()){

                    $sessionsBag->addMissedSession($enrollmentSession);
                }
                elseif( !$enrollmentSession->status->isAttended() AND $enrollmentSession->scheduleSession()->isPast()){
                    $sessionsBag->addMissedSession($enrollmentSession);
                }
                //today (es hoy y no ha comenzado)
                elseif ($enrollmentSession->scheduleSession()->isToday() AND $enrollmentSession->scheduleSession()->isFuture()){
                    $sessionsBag->addTodaySession($enrollmentSession);
                }

                //futura
                elseif ($enrollmentSession->scheduleSession()->isFuture()){
                    $sessionsBag->addNextSession($enrollmentSession);
                }

                //completed
                elseif($enrollmentSession->status->isAttended()){
                    $sessionsBag->addCompletedSession($enrollmentSession);
                }

                else{

                    dd('enrollment session no se puede agregar a ninguna bolsa');
                }
            }
            else{
                //cuando la coaching week no tiene sesión asociada

                if ($coachingWeek->isMakeup()){
                    continue;
                }

                if ($coachingWeek->isPast()){
                    $sessionsBag->addMissedWeeks($coachingWeek);
                }
                else{
                    $sessionsBag->addNextWeek($coachingWeek);
                }
            }
        }

        foreach ($enrollmentSessionsRegister->extraSessions() as $extraSession){
            //enrollmentSession configuradas como extra session
            $this->assignEnrollmentSessionInBag($extraSession, $sessionsBag);
            $sessionsBag->addTotalSessionsByExtraSession();
        }

        return $sessionsBag;
    }


    /**
     * @param SessionsCollection $sessionsCollection  números de sesiones ordenados que tiene que hacer el estudiante
     * @param SessionRegister $enrollmentSessionsRegister las sesiones registradas del estudiante
     */
    public function buildForFlex(SessionsCollection $sessionsCollection, SessionRegister $enrollmentSessionsRegister):SessionsFlexBag{

        $sessionsBag = app(SessionsFlexBag::class, ['numTotalSessions' => $sessionsCollection->count()]);


        foreach ($sessionsCollection->orderByNumberSession() as $flexSession){

            if ($enrollmentSessionsRegister->hasSessionOrder($flexSession->sessionOrderObject())){
                //cuando la sessión del curso tiene un enrollment sesión asociada, es decir, está agendada

                $enrollmentSession = $enrollmentSessionsRegister->filterByOrderWithoutMakeup($flexSession->sessionOrderObject());
                $this->assignEnrollmentSessionInBag($enrollmentSession, $sessionsBag);

            }
            else{
                //cuando el número de sesión no está agendada
                $sessionsBag->addNextFlexSession($flexSession);
            }
        }


        foreach ($enrollmentSessionsRegister->extraSessions() as $extraSession){
            //enrollmentSession configuradas como extra session
            $this->assignEnrollmentSessionInBag($extraSession, $sessionsBag);
            $sessionsBag->addTotalSessionsByExtraSession();
        }

        return $sessionsBag;

    }

    /**
     * @param EnrollmentSession $enrollmentSession
     * @param mixed $sessionsBag
     */
    private function assignEnrollmentSessionInBag(EnrollmentSession $enrollmentSession, mixed $sessionsBag): void
    {
        //missed (estado perdida o (estado es no atendida y sesión finalizada)
        if ($enrollmentSession->status->isMissed()) {
            $sessionsBag->addMissedSession($enrollmentSession);
        } elseif ( ! $enrollmentSession->status->isAttended() and $enrollmentSession->scheduleSession()->isPast()) {
            $sessionsBag->addMissedSession($enrollmentSession);
        } //today (es hoy y no ha comenzado)
        elseif ($enrollmentSession->scheduleSession()->isToday() and $enrollmentSession->scheduleSession()->isFuture()) {
            $sessionsBag->addTodaySession($enrollmentSession);
        } //futura
        elseif ($enrollmentSession->scheduleSession()->isFuture()) {
            $sessionsBag->addNextSession($enrollmentSession);
        } //completed
        elseif ($enrollmentSession->status->isAttended()) {
            $sessionsBag->addCompletedSession($enrollmentSession);
        } else {

            dd('enrollment session no se puede agregar a ninguna bolsa');
        }
    }
}
