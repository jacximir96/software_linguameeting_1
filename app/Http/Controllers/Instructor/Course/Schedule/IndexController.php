<?php
namespace App\Http\Controllers\Instructor\Course\Schedule;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Schedule\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class IndexController extends Controller
{
    use Breadcrumable;

    public function __construct (){

    }

    public function __invoke(Request $request)
    {
        $instructor = user()->id;

        $courses = DB::table('section')
                        ->join('session', 'section.course_id', '=', 'session.course_id')
                        ->join('course', 'section.course_id', '=', 'course.id')
                        ->join('user', 'session.coach_id', '=', 'user.id')
                        ->join('country','user.country_id','=','country.id')
                        ->select('session.day', 'session.start_time', 'session.end_time', 'course.id', 'course.name as name_course', 'session.coach_id', 'user.name as name_user', 'user.lastname', 'user.url_photo', 'country.name as countryName', 'country.iso2 as flag')
                        ->where('instructor_id', $instructor)
                        ->distinct()
                        ->get();
            
        $startOfWeek = Session::get('startOfWeek', now()->locale('es')->startOfWeek());
        $direction = $request->input('direction');
            
        if ($direction === 'next') {
            $startOfWeek->addWeek();
        } elseif ($direction === 'back') {
            $startOfWeek->subWeek();
        }
    
        Session::put('startOfWeek', $startOfWeek);
            
        $days = [];
            
            if($request->has('course')){
                if($request->course === 'all'){
                    $courseCounts = [];
                    foreach ($courses as $course) {
                        if (!isset($courseCounts[$course->id])) {
                            $courseCounts[$course->id] = 1;
                        }
                        
                        $courseCount = $courseCounts[$course->id]; 
                        $totalCourses = $courses->where('id', $course->id)->count(); 

                        $days[] = [
                            'day' => $course->day,
                            'start_time' => $course->start_time,
                            'end_time' => $course->end_time,
                            'id' => $course->id,
                            'name_course' => $course->name_course,
                            'name_user' => $course->name_user,
                            'lastname' => $course->lastname,
                            'countryName' => $course->countryName,
                            'flag' => $course->flag,
                            'session' => "$courseCount/$totalCourses", 
                        ];
                        $courseCounts[$course->id]++; 

                        $courseSelected = null;
                    }                
                }else{
                    $courseCounts = [];
                    foreach ($courses as $course) {
                        if ($course->id == $request->course) {

                            if (!isset($courseCounts[$course->id])) {
                                $courseCounts[$course->id] = 1;
                            }
                            
                            $courseCount = $courseCounts[$course->id]; 
                            $totalCourses = $courses->where('id', $course->id)->count(); 

                            $days[] = [
                                'day' => $course->day,
                                'start_time' => $course->start_time,
                                'end_time' => $course->end_time,
                                'id' => $course->id,
                                'name_course' => $course->name_course,
                                'name_user' => $course->name_user,
                                'lastname' => $course->lastname,
                                'countryName' => $course->countryName,
                                'flag' => $course->flag,
                                'session' => "$courseCount/$totalCourses", 
                            ];

                            $courseCounts[$course->id]++; 

                            $courseSelected = DB::table('course')
                                                ->select('course.*')
                                                ->where('course.id', '=', $request->course)
                                                ->first();
                        }
                    }
                }
            }else{
                $courseCounts = [];
                foreach ($courses as $course) {
                    if (!isset($courseCounts[$course->id])) {
                        $courseCounts[$course->id] = 1;
                    }
                    
                    $courseCount = $courseCounts[$course->id]; 
                    $totalCourses = $courses->where('id', $course->id)->count(); 
                    
                    $days[] = [
                        'day' => $course->day,
                        'coach_id' => $course->coach_id,
                        'start_time' => $course->start_time,
                        'end_time' => $course->end_time,
                        'id' => $course->id,
                        'name_course' => $course->name_course,
                        'name_user' => $course->name_user,
                        'lastname' => $course->lastname,
                        'countryName' => $course->countryName,
                        'flag' => $course->flag,
                        'session' => "$courseCount/$totalCourses", 
                    ];
                    
                    $courseCounts[$course->id]++; 
                    
                    $courseSelected = null;
                }
            }
            
        if($request->has('course_id')){
            $days = [];
            $courseCounts = [];
            foreach ($courses as $course) {
                if ($course->id == $request->course_id) {

                    if (!isset($courseCounts[$course->id])) {
                        $courseCounts[$course->id] = 1;
                    }
                    
                    $courseCount = $courseCounts[$course->id]; 
                    $totalCourses = $courses->where('id', $course->id)->count(); 

                    $days[] = [
                        'day' => $course->day,
                        'start_time' => $course->start_time,
                        'end_time' => $course->end_time,
                        'id' => $course->id,
                        'name_course' => $course->name_course,
                        'name_user' => $course->name_user,
                        'lastname' => $course->lastname,
                        'countryName' => $course->countryName,
                        'flag' => $course->flag,
                        'session' => "$courseCount/$totalCourses", 
                    ];

                    $courseCounts[$course->id]++; 
                    
                    $courseSelected = DB::table('course')
                                        ->select('course.*')
                                        ->where('course.id', '=', $request->course_id)
                                         ->first();
                    }
            }
            
        }

        $coursesList = DB::table('coach_info')
            ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
            ->join('section', 'session.course_id', '=', 'section.course_id')
            ->join('user','coach_info.user_id','=','user.id')
            ->join('course','section.course_id','=','course.id')
            ->select('course.*',    )
            ->where('section.instructor_id', '=', $instructor)
            ->distinct()
            ->get(); 
            
        $coaches = DB::table('coach_info')
            ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
            ->join('section', 'session.course_id', '=', 'section.course_id')
            ->join('user','coach_info.user_id','=','user.id')
            ->join('country','user.country_id','=','country.id')
            ->select('user.id', 'user.name', 'user.lastname', 'user.url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
            ->where('section.instructor_id', '=', $instructor)
            ->distinct()
            ->get();        

    $breadcrumb = new IndexBreadcrumb();
    $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);  
    
    return view('instructor.course.schedule.index', compact('days', 'coursesList', 'startOfWeek', 'coaches', 'courseSelected'));
    }
}
