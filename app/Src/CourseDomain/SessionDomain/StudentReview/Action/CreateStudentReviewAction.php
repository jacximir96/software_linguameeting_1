<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Action;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Repository\SessionStatusRepository;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReview\Request\StudentReviewRequest;
use Carbon\Carbon;

class CreateStudentReviewAction
{
    private SessionStatusRepository $sessionStatusRepository;

    public function __construct(SessionStatusRepository $sessionStatusRepository)
    {

        $this->sessionStatusRepository = $sessionStatusRepository;
    }

    public function handle(StudentReviewRequest $request, EnrollmentSession $enrollmentSession): StudentReview
    {

        $sessionFeedback = new StudentReview();
        $sessionFeedback->enrollment_session_id = $enrollmentSession->id;
        $sessionFeedback->participation_type_id = $request->participation_type_id;
        $sessionFeedback->prepared_class_type_id = $request->prepared_class_type_id;
        $sessionFeedback->puntuality_type_id = $request->puntuality_type_id;
        $sessionFeedback->observations = $request->observations ?? null;

        $sessionFeedback->save();

        $this->updateSessionAttended($request, $sessionFeedback);

        return $sessionFeedback;
    }

    private function updateSessionAttended(StudentReviewRequest $request, StudentReview $sessionFeedback)
    {

        $enrollmentSession = $sessionFeedback->enrollmentSession;

        if ($request->isAttended()) {
            $status = $this->sessionStatusRepository->findAttended();
        } else {
            $status = $this->sessionStatusRepository->findMissed();
        }

        $enrollmentSession->session_status_id = $status->id;
        $enrollmentSession->status_at = Carbon::now();
        $enrollmentSession->save();
    }
}
