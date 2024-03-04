<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStatsCollection;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\StudentDomain\Enrollment\Service\SessionsBagBuilder;
use Illuminate\Support\Collection;


class ShowEnrollmentFlexPresenter
{
    //construct
    private EnrollmentRepository $enrollmentRepository;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    private ReviewStatsBuilder $reviewStatsBuilder;

    //status
    private Enrollment $enrollment;

    public function __construct (EnrollmentRepository $enrollmentRepository,
                                 EnrollmentSessionRepository $enrollmentSessionRepository,
                                 ExperienceRegisterRepository $experienceRegisterRepository,
                                 ReviewStatsBuilder $reviewStatsBuilder){

        $this->enrollmentRepository = $enrollmentRepository;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }

    public function handle(Enrollment $enrollment):ShowEnrollmentFlexResponse{

        $this->initialize($enrollment);

        $experienceRegisters = $this->obtainExperiencesRegisters();

        $sessionRegister = $this->obtainEnrollmentSessions(); //enrollment session

        $sessionsCollection = $this->obtainSessionCollection();

        //aquí se construye las diferentes 'bolsas' de sesiones del curse: missed, next, completed..
        $sessionsBagBuilder = app(SessionsBagBuilder::class);
        $sessionsBag = $sessionsBagBuilder->buildForFlex ($sessionsCollection, $sessionRegister);

        $reviewsStatsCollection = $this->obtainReviewsStats();

        $extraSessionsAvailable = $this->obtainExtraSessionsAvailables();

        $nextSessionOrder = $this->obtainNextSessionOrder();

        return new ShowEnrollmentFlexResponse($this->enrollment, $experienceRegisters, $sessionRegister,
            $sessionsCollection, $reviewsStatsCollection, $sessionsBag, $extraSessionsAvailable, $nextSessionOrder);

    }

    private function initialize (Enrollment $enrollment){

        $enrollment->load($this->enrollmentRepository->relationshipsWithSession());

        $this->enrollment = $enrollment;
    }

    private function obtainExperiencesRegisters ():Collection{

        return $this->experienceRegisterRepository->obtainExperienceByEnrollment($this->enrollment);
    }

    private function obtainSessionCollection ():SessionsCollection
    {
        $course = $this->enrollment->section->course;

        return new SessionsCollection($course->obtainFlexSessions()->get());
    }

    private function obtainEnrollmentSessions ():SessionRegister{

        return new SessionRegister($this->enrollment->enrollmentSession);
    }

    private function obtainReviewsStats ():ReviewsStatsCollection{

        $coaches = collect();

        foreach ($this->enrollment->enrollmentSession as $enrollmentSession){
            $coaches->push($enrollmentSession->session->coach);
        }

        return $this->reviewStatsBuilder->buildCollection($coaches);
    }

    private function obtainExtraSessionsAvailables ():Collection{

        $extraSessions = collect();

        foreach ($this->enrollment->extraSession as $extraSession){

            if ( ! $extraSession->hasBeenUsed()){
                $extraSessions->push($extraSession);
            }

        }

        return $extraSessions;
    }

    private function obtainNextSessionOrder ():SessionOrder{

        return $this->enrollmentSessionRepository->nextSessionOrder ($this->enrollment);
    }
}
