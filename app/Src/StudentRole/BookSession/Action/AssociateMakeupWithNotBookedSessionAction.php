<?php
namespace App\Src\StudentRole\BookSession\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use Spatie\Activitylog\Models\Activity;


class AssociateMakeupWithNotBookedSessionAction
{

    public function handle(EnrollmentSession $enrollmentSession, Makeup $makeup):EnrollmentSession{

        $enrollmentSession->makeup_id = $makeup->id;
        $enrollmentSession->save();

        $this->registerActivity($enrollmentSession);

        return $enrollmentSession;
    }

    private function registerActivity (EnrollmentSession $enrollmentSession):Activity{

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollmentSessionWithMakeup($enrollmentSession)->buildProperty('enrollment_session', 'Enrollment')
        );

        return  activity()
            ->causedBy(user())
            ->performedOn($enrollmentSession)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.sessions.makeup.use_in_session'));
    }

}
