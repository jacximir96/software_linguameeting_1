<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Action;

use App\Src\CourseDomain\SessionDomain\SessionStatus\Repository\SessionStatusRepository;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReview\Request\StudentReviewRequest;
use Carbon\Carbon;

class UpdateStudentReviewAction
{
    private SessionStatusRepository $sessionStatusRepository;

    public function __construct(SessionStatusRepository $sessionStatusRepository)
    {

        $this->sessionStatusRepository = $sessionStatusRepository;
    }

    public function handle(StudentReviewRequest $request, StudentReview $sessionFeedback): StudentReview
    {

        $this->updateAssistence($request, $sessionFeedback);

        return $this->updateFeedback($request, $sessionFeedback);
    }

    private function updateAssistence(StudentReviewRequest $request, StudentReview $sessionFeedback)
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

    private function updateFeedback(StudentReviewRequest $request, StudentReview $sessionFeedback): StudentReview
    {
        $sessionFeedback->participation_type_id = $request->participation_type_id;
        $sessionFeedback->prepared_class_type_id = $request->prepared_class_type_id;
        $sessionFeedback->puntuality_type_id = $request->puntuality_type_id;
        $sessionFeedback->observations = $request->observations ?? null;

        $sessionFeedback->save();

        return $sessionFeedback;
    }
}
