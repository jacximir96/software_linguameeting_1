<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\DeleteEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;

//quita el coaching_week o elimina la sesión si es makeup. Ambas, cuando se cambia el curso de coaching weeks a flex.
class CoachingWeekAssignToStudentsSessionsAction
{

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private DeleteEnrollmentSessionCommand $deleteEnrollmentSessionCommand;

    public function __construct (EnrollmentSessionRepository $enrollmentSessionRepository, DeleteEnrollmentSessionCommand $deleteEnrollmentSessionCommand){

        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->deleteEnrollmentSessionCommand = $deleteEnrollmentSessionCommand;
    }

    public function handle(Course $course, CoachingWeek $coachingWeek)
    {

        $enrollmentSessions = $this->enrollmentSessionRepository->enrollmentSessionsFromCourseAndCoachingWeek($course, $coachingWeek);

        if ($enrollmentSessions->count()) {

            foreach ($enrollmentSessions as $enrollmentSession){

                if ($enrollmentSession->isMakeup()){
                    $this->deleteEnrollmentSessionCommand->handle($enrollmentSession);
                }
                else{
                    $enrollmentSession->coaching_week_id = null;
                    $enrollmentSession->save();
                }
            }
        }

        //todo implement this method
        //universityController - 4420
        //add index to new table
    }
}
