<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStatsCollection;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\StudentDomain\Enrollment\Service\SessionsBagBuilder;
use Illuminate\Support\Collection;


class ShowEnrollmentWeeksPresenter
{
    //construct
    private EnrollmentRepository $enrollmentRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    private ReviewStatsBuilder $reviewStatsBuilder;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    //status

    private Enrollment $enrollment;

    public function __construct (EnrollmentRepository $enrollmentRepository,
                                 ExperienceRegisterRepository $experienceRegisterRepository,
                                 ReviewStatsBuilder $reviewStatsBuilder,
                                 EnrollmentSessionRepository $enrollmentSessionRepository){

        $this->enrollmentRepository = $enrollmentRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function handle(Enrollment $enrollment):ShowEnrollmentWeeksResponse{

        $this->initialize($enrollment);

        //experiencias del usuario
        $experienceRegisters = $this->obtainExperiencesRegisters();


        //construir las 'bolsas' de sesiones y su estado
        $sessionRegister = $this->obtainEnrollmentSessions();
        $sessionWeeks = $this->obtainSessionWeeks();
        $sessionWeeksWithouMakeup = $this->obtainSessionWeeksWithMakeup();
        $sessionsBagBuilder = app(SessionsBagBuilder::class);
        $sessionsBag = $sessionsBagBuilder->buildForWeeks ($sessionWeeksWithouMakeup, $sessionRegister);

        //estadísticas de coaches
        $reviewsStatsCollection = $this->obtainReviewsStats();

        $extraSessionsAvailable = $this->obtainExtraSessionsAvailables();

        $nextSessionOrder = $this->obtainNextSessionOrder();

        return new ShowEnrollmentWeeksResponse($this->enrollment, $experienceRegisters, $sessionRegister,
            $sessionWeeks, $reviewsStatsCollection, $sessionsBag, $extraSessionsAvailable, $nextSessionOrder);

    }

    private function initialize (Enrollment $enrollment){

        $enrollment->load($this->enrollmentRepository->relationshipsWithSession());

        $this->enrollment = $enrollment;
    }

    private function obtainExperiencesRegisters ():Collection{

        return $this->experienceRegisterRepository->obtainExperienceByEnrollment($this->enrollment);
    }

    private function obtainSessionWeeks ():SessionsCollection{

        $course = $this->enrollment->section->course;

        return new SessionsCollection($course->coachingWeeksOrdered());
    }

    private function obtainSessionWeeksWithMakeup ():SessionsCollection{

        $course = $this->enrollment->section->course;

        return new SessionsCollection($course->coachingWeeksOrderedWithoutMakeUps());
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
