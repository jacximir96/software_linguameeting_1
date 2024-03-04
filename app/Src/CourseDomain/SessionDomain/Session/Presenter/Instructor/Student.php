<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\NumericGrade;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class Student
{

    private User $student;
    private Enrollment $enrollment;
    private Collection $reviews; //collection de StudentReview con clave 'session_id'

    private int $numExperiences;

    public function __construct (User $student, Enrollment $enrollment){

        $this->student = $student;
        $this->enrollment = $enrollment;
        $this->reviews = collect();

        $this->numExperiences = 0;
    }

    public function add(StudentReview $review){

        $sessionId = $review->enrollmentSession->session_id;

        $this->reviews->put($sessionId, $review);
    }

    public function student ():User{
        return $this->student;
    }

    public function enrollment():Enrollment{
        return $this->enrollment;
    }

    public function countReviews():int{
        return $this->reviews->count();
    }

    public function applyForSession (int $sessionNumber){

        $sessionSetup = $this->enrollment->course()->conversationPackage->obtainSessionSetup();

        return $sessionNumber <= $sessionSetup->sessionNumber()->get();
    }


    public function gradeInSession (int $sessionNumber):NumericGrade{

        foreach ($this->reviews as $review){

            if ($review->enrollmentSession->sessionOrder()->isSameOrder($sessionNumber)){

                if ($review->hasGrade()){
                    return $review->grade()->total();
                }
            }
        }

        return new NumericGrade(0);
    }

    public function totalGrade ():NumericGrade{

        $total = 0;

        foreach ($this->reviews as $review){

            if ($review->hasGrade()){
                $total += $review->grade()->total()->get();
            }
        }

        return new NumericGrade($total);
    }

    public function numExperiences ():int{

        //todo ¿quitar esto? dejó de hacer falta al ver un cambio en el diseño
        return 0;

        $numExperiences = 0;
        $coursePeriod = $this->enrollment->course()->period();

        foreach ($this->student->experienceRegister as $experienceRegister){

            if ($experienceRegister->isAttendance()){
                if ($coursePeriod->contains($experienceRegister->experience->start)){
                    $numExperiences++;
                }
            }
        }

        return $numExperiences;
    }
}
