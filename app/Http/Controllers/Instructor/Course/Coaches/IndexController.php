<?php
namespace App\Http\Controllers\Instructor\Course\Coaches;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Src\InstructorDomain\Coaches\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use Illuminate\Support\Facades\DB;



class IndexController extends Controller
{
    use Breadcrumable;

    public function __construct (){

    }


    public function __invoke(Request $request)
    {
        $userId = auth()->id();

        if($request->has('course')){
            if ($request->course === 'all') {
                $coachesQuery = DB::table('coach_info')
                ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                ->join('section', 'session.course_id', '=', 'section.course_id')
                ->join('user','coach_info.user_id','=','user.id')
                ->join('country','user.country_id','=','country.id')
                ->select('user.id', 'user.name', 'user.lastname', 'user.url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                ->where('section.instructor_id', '=', $userId)
                ->distinct();
                
            }else{
                $coachesQuery = DB::table('coach_info')
                ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                ->join('section', 'session.course_id', '=', 'section.course_id')
                ->join('user','coach_info.user_id','=','user.id')
                ->join('country','user.country_id','=','country.id')
                ->select('user.id', 'user.name', 'user.lastname', 'user.url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                ->where('section.instructor_id', '=', $userId)
                ->where('section.course_id', '=', $request->course)
                ->distinct();
                
            }
        }else{
            $coachesQuery = DB::table('coach_info')
            ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
            ->join('section', 'session.course_id', '=', 'section.course_id')
            ->join('user','coach_info.user_id','=','user.id')
            ->join('country','user.country_id','=','country.id')
            ->select('user.id', 'user.name', 'user.lastname', 'user.url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
            ->where('section.instructor_id', '=', $userId)
            ->distinct();
            
        }

        $courses = DB::table('coach_info')
            ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
            ->join('section', 'session.course_id', '=', 'section.course_id')
            ->join('user','coach_info.user_id','=','user.id')
            ->join('course','section.course_id','=','course.id')
            ->select('course.*')
            ->where('section.instructor_id', '=', $userId)
            ->distinct()
            ->get();

        $coaches = $coachesQuery->get();    
        
        // $feedbacks = $coachesQuery
        //                 ->join('coach_feedback', 'user.id', '=', 'coach_feedback.coach_id')
        //                 ->select('coach_feedback.*')
        //                 ->get();
        // dd($feedbacks);
        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        
        return view('instructor.course.coaches.index', compact('coaches', 'courses'));
    }
}
