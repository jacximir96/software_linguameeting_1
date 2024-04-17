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

                $coachesQuery = DB::table('section')
                    ->join('course_coach', 'section.course_id', '=', 'course_coach.course_id')
                    ->join('user', 'course_coach.coach_id', '=', 'user.id')
                    ->join('country','user.country_id','=','country.id')
                    ->leftJoin('coach_info', 'user.id', '=', 'coach_info.user_id')
                    ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                    ->where('section.instructor_id', $userId)
                    ->select('user.id', 'user.name', 'user.lastname', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description', 'profile_image.filename', 'profile_image.original_name', 'profile_image.mime')
                    ->distinct();
                
            }else{
                $coachesQuery = DB::table('section')
                ->join('course_coach', 'section.course_id', '=', 'course_coach.course_id')
                ->join('user', 'course_coach.coach_id', '=', 'user.id')
                ->join('country','user.country_id','=','country.id')
                ->leftJoin('coach_info', 'user.id', '=', 'coach_info.user_id')
                ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                ->where('section.instructor_id', $userId)
                ->where('section.course_id', '=', $request->course)
                ->select('user.id', 'user.name', 'user.lastname', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description', 'profile_image.filename', 'profile_image.original_name', 'profile_image.mime')
                ->distinct();
                
            }
        }else{

            $coachesQuery = DB::table('section')
                    ->join('course_coach', 'section.course_id', '=', 'course_coach.course_id')
                    ->join('user', 'course_coach.coach_id', '=', 'user.id')
                    ->join('country','user.country_id','=','country.id')
                    ->leftJoin('coach_info', 'user.id', '=', 'coach_info.user_id')
                    ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                    ->where('section.instructor_id', $userId)
                    ->select('user.id', 'user.name', 'user.lastname', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description', 'profile_image.filename', 'profile_image.original_name', 'profile_image.mime')
                    ->distinct();
        }

        $courses = DB::table('section')
                        ->join('course', 'section.course_id', '=', 'course.id')
                        ->join('course_coach', 'course.id', '=', 'course_coach.course_id')
                        ->join('user', 'section.instructor_id', '=', 'user.id')
                        ->where('section.instructor_id', $userId)
                        ->select('course.*')
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
