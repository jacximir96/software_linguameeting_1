<?php
namespace Database\Seeders;

use App\Src\_Old\Model\StudentsCourses;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


class ImportStudentAction
{

    use TraitImport;

    public function handle(User $user){

        $this->importEnrollment($user);


    }

    private function importEnrollment (User $user){

        $oldsEnrollments = StudentsCourses::where('id_user', '=', $user->id)->get(); //matrículas


        foreach ($oldsEnrollments as $oldEnrollment){

            $section = Section::find($oldEnrollment->section_id);

            if ($section){
                $enrollment = new Enrollment();
                $enrollment->student_id = $user->id;
                $enrollment->section_id = $oldEnrollment->section_id;
                $enrollment->active = $oldEnrollment->active;

                //todo revisar esto
                dd('seleccionar aquí el estado correcto para la matríula');
                $enrollment->status_at = null;
                if (!is_null($oldEnrollment->date_assign)){
                    $enrollment->status_at = $oldEnrollment->date_assign ? Carbon::parse($oldEnrollment->date_assign, 'Europe/Madrid')->setTimezone('UTC') : null;
                }

                $enrollment->save();
            }
        }
    }
}
