<?php

namespace App\Src\StudentDomain\Enrollment\Action;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\CancelEnrollmentSessionAction;
use App\Src\NotificationDomain\Notification\Action\Command\SupportNotificationCreator;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Action\Command\DeleteExtraSessionCommand;
use App\Src\StudentDomain\Makeup\Action\Command\DeleteMakeupCommand;

class DeleteEnrollmentAction
{
    private DeleteExtraSessionCommand $deleteExtraSessionCommand;

    private DeleteMakeupCommand $deleteMakeupCommand;

    private CancelEnrollmentSessionAction $cancelEnrollmentSessionAction;

    private SupportNotificationCreator $notificationCreator;

    public function __construct(DeleteExtraSessionCommand $deleteExtraSessionCommand,
        DeleteMakeupCommand $deleteMakeupCommand,
        CancelEnrollmentSessionAction $cancelEnrollmentSessionAction,
        SupportNotificationCreator $notificationCreator)
    {

        $this->deleteExtraSessionCommand = $deleteExtraSessionCommand;
        $this->deleteMakeupCommand = $deleteMakeupCommand;
        $this->cancelEnrollmentSessionAction = $cancelEnrollmentSessionAction;
        $this->notificationCreator = $notificationCreator;
    }

    public function handle(Enrollment $enrollment, bool $checkCanDelete = true): Enrollment
    {

        try {

            $this->deleteAccommodation($enrollment);

            $this->deleteExtrasession($enrollment);

            $this->deleteMakeups($enrollment);

            $this->deleteEnrollmentSessions($enrollment, $checkCanDelete);

            $enrollment->delete();

            return $enrollment;

        } catch (\Throwable $exception) {
            $this->notificationCreator->createEnrollmentDeleteErrorNotification($enrollment, $exception);
            throw $exception;
        }
    }

    private function deleteAccommodation(Enrollment $enrollment)
    {
        $enrollment->accommodation()->delete();
    }

    private function deleteExtrasession(Enrollment $enrollment)
    {

        foreach ($enrollment->extraSession as $extraSession) {
            $this->deleteExtraSessionCommand->handle($extraSession);
        }
    }

    private function deleteMakeups(Enrollment $enrollment)
    {

        foreach ($enrollment->makeup as $makeup) {
            $this->deleteMakeupCommand->handle($makeup);
        }
    }

    private function deleteEnrollmentSessions(Enrollment $enrollment, bool $checkCanDelete)
    {

        foreach ($enrollment->enrollmentSession as $session) {
            $this->cancelEnrollmentSessionAction->handle($session, $checkCanDelete);
        }
    }
}
