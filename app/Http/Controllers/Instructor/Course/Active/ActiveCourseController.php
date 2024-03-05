<?php

namespace App\Http\Controllers\Instructor\Course\Active;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Http\Controllers\Admin\Instructor\Presentable;
use App\Http\Models\SemesterModel;
use App\Http\Models\CourseModel;
use App\Http\Models\UniversityModel;
use App\Http\Models\TimezoneModel;
use App\Http\Models\SessionModel;
use App\Http\Models\CoachingWeekModel;
use App\Http\Models\EnrollmentModel;
use App\Http\Models\SectionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiveCourseController extends Controller
{
    use Breadcrumable;

    public function closeCourse(Request $request, $id) {

        $instructor = user();
        $course_id = intval($id);
        $course_id = intval($request->idSection);
        $course_code = intval($request->idCode);
        $close = true;
        
        $course = CourseModel::select('id','university_id','is_flex','closed_date')->where('id','=',$course_id)->first();
        
        $section = SectionModel::select('id')->where('course_id','=',$course_id)->first();
        
        // Buscar zona horaria de la universidad y ver que no hay estudiantes con sesiones futuras o pasadas. 
        // Comparar con zona horaria estudiante.
        $university = UniversityModel::select('university.id','timezone.name')
                      ->leftJoin('timezone','university.timezone_id','=','timezone.id')
                      ->where('university.id','=',$course->university_id)
                      ->get();

        $today_uni = Carbon::now()->setTimezone($university[0]->name);
        
        if (empty($course->is_flex)) {
            $dueDates = CoachingWeekModel::select('end_date')->where('course_id',$course_id)->first();
            
            $date_due = Carbon::parse($dueDates->end_date . " " . $today_uni->format('H:i:s'))->setTimezone($university[0]->name);
            
            if ($date_due->toDateTimeString() >= $today_uni->toDateTimeString()) {
                // no se puede cerrar porque existen sesiones futuras.
                $close = false;
            }
        } else {
            $sessions = SessionModel::where('course_id',$course_id)
                        ->where(DB::raw("CONCAT(session.day, ' ', session.end_time)"), '>=', $today_uni->subDays(1)->toDateTimeString())
                        ->get();

            $today_uni->addDays(1)->toDateTimeString();

            foreach ($sessions as $session) {

                $date_end_ses = Carbon::parse($session->day . " " . $session->end_time)->setTimezone($university[0]->name);

                if ($date_end_ses->toDateTimeString() >= $today_uni->toDateTimeString()) {
                    // no se puede cerrar porque existen sesiones futuras.
                    $close = false;
                }
            }
        }
        
        if ($close) {
            
            $today_uni->subDays(1);
            $dayBefore = $today_uni->format('Y-m-d');
            
            // Cierro con el día anterior porque sino no pasa a cursos pasados. Pendiente confirmar
            $result_update = CourseModel::where("id", $course_id)->update(["end_date" => $dayBefore ,"closed_date" => $dayBefore]);
            
            // una vez puesta la fecha fin, desactivar a todos los estudiantes en students_courses.
            if ($result_update) {
                $enrollment = EnrollmentModel::where("section_id", $section->id)->update(["active" => 0]);
                
                $today_uni->subDays(14);

                $courseSection = DB::table('section')
                                    ->join('course', 'section.course_id', '=', 'course.id')
                                    ->select('course.*')
                                    ->where('section.instructor_id', $instructor->id)
                                    ->where('section.code', '=', $course_code)
                                    ->first();
                
                $updateCourse = DB::table('course')
                                    ->where('id', $courseSection->id)
                                    ->update(['end_date' => $today_uni]);
            }
            if($updateCourse != 0){
                return redirect()->route('get.instructor.course.past_course.index')->with('success', 'Course closed successfully.'); 
            }
            else{
                return redirect()->back()->with('error', 'The course cannot be closed');
            }      
            
        } else {
            return redirect()->back()->with('error', "Students with sessions reserved. The course cannot be closed until sessions are completed.");
        }
    }
}