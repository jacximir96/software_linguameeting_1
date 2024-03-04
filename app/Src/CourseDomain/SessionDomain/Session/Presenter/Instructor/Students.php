<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use Illuminate\Support\Collection;


class Students
{

    private Collection $students;

    private int $minSessions = 99;

    private int $maxSessions = 0;

    public function __construct(){
        $this->students = collect();
    }

    public function get(): Collection
    {
        return $this->students;
    }

    public function minSessions ():int{
        return $this->minSessions;
    }

    public function maxSessions ():int{
        return $this->maxSessions;
    }

    public function addReview(StudentReview $studentReview){

        $studentId = $studentReview->enrollmentSession->enrollment->student_id;

        if ( ! $this->students->has($studentId)){
            $enrollment = $studentReview->enrollmentSession->enrollment;

            if ($enrollment->enrollmentTarget){
                //si la matrícula tiene jn destino (es decir, fue cambiada en algún momento de curso), no la procesamos
                return;
            }

            $student = new Student($enrollment->user, $enrollment);
            $this->students->put($studentId, $student);
        }

        //añadimos la review
        $student = $this->students->get($studentId);
        $student->add($studentReview);

        //actualizamos el número de sesiones mínimas y máximas a mostrar en la tabla del gradebook
        $sessionSetup = $studentReview->enrollmentSession->session->course->conversationPackage->obtainSessionSetup();

        if ($sessionSetup->sessionNumber()->get() < $this->minSessions){
            $this->minSessions = $sessionSetup->sessionNumber()->get();
        }

        if ($sessionSetup->sessionNumber()->get() > $this->maxSessions){
            $this->maxSessions = $sessionSetup->sessionNumber()->get();
        }
    }
}
