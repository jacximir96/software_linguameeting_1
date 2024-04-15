<?php

namespace App\Http\Controllers\Instructor\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\CourseDomain\CoachingForm\Service\InstructionsFinder;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\OneOnOneFlexPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\OneOnOneWeekPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SmallGroupFlexPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SmallGroupWeekPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleFlexPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleWeeksPresenter;
use App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor\ShowCourseBreadcrumb;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Http\Controllers\Admin\Course\CoachingForm\Wizard\Summarizable;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\TimeDomain\Date\Service\PaginatorPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Src\InstructorDomain\Canvas\Repository\CanvasRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShowController extends Controller
{
    use Breadcrumable, Summarizable;

    private CourseRepository $courseRepository;
    private CanvasRepository $canvasRepository;
    private CoachRepository $coachRepository;
    private GuideRepository $guideRepository;
    private ReviewStatsBuilder $reviewStatsBuilder;

    public function __construct(
        CourseRepository $courseRepository,
        CanvasRepository $canvasRepository,
        CoachRepository $coachRepository,
        GuideRepository $guideRepository,
        ReviewStatsBuilder $reviewStatsBuilder
    ) {

        $this->courseRepository = $courseRepository;
        $this->canvasRepository = $canvasRepository;
        $this->coachRepository = $coachRepository;
        $this->guideRepository = $guideRepository;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }


    public function __invoke(Course $course, Request $request)
    {
       
        try {
         
            $instructor = user();

            $breadcrumb = new ShowCourseBreadcrumb($course);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $course->load($this->courseRepository->relationsWithSections());
            $canvas = $this->canvasRepository->canvasInstructor($course, $instructor);

            $students = DB::table('section')
                            ->join('enrollment', 'section.id', '=', 'enrollment.section_id')
                            ->join('user', 'enrollment.student_id', '=', 'user.id')         
                            ->select('enrollment.id','enrollment.student_id', 'enrollment.section_id', 'user.name', 'user.lastname')
                            ->where('section.course_id', $course->id)
                            ->get();

            $canvas_id = "";
            if ( ! empty($canvas)) {
                $canvas_id = $canvas->canvas_course_id;
            }

            $this->buildCourseSummaryFromCourse($course);

            $coaches = $this->coachRepository->coachWithSessionsInCourse($course);
            $reviewsStatsCollection = $this->reviewStatsBuilder->buildCollection($coaches);

            $this->configAssignments($course);

            $this->configSchedule($course);

            $guideByDefault = $this->obtainGuideByDefault($course);
         
            $studentsInSection = new Collection;

            foreach ($course->section as $section) {
                $studentsInSection[$section->id] = $students->where('section_id', $section->id);
            }
  
            
            $coursesActive = DB::table('section')
                            ->join('session', 'section.course_id', '=', 'session.course_id')
                            ->join('course', 'section.course_id', '=', 'course.id')
                            ->join('user', 'session.coach_id', '=', 'user.id')
                            ->join('country','user.country_id','=','country.id')
                            ->select('session.day', 'session.start_time', 'session.end_time', 'session.id as idSession','course.id', 'course.name as name_course', 'session.coach_id', 'user.name as name_user', 'user.lastname', 'user.url_photo', 'country.name as countryName', 'country.iso2 as flag', 'section.id as idSection')
                            ->where('instructor_id', $instructor->id)
                            ->where('course.id', $course->id)
                            ->distinct()
                            ->get();
            
           
            $startOfWeek = Session::get('startOfWeek', now()->locale('es')->startOfWeek());
    
            $direction = $request->input('direction');
                 

            if ($direction === 'next') {
                $startOfWeek->addWeek();
                Session::put('startOfWeek', $startOfWeek);
                
                $days = [];
                $courseCounts = [];
                        foreach ($coursesActive as $courseActive) {
                            if (!isset($courseCounts[$courseActive->id])) {
                                $courseCounts[$courseActive->id] = 1;
                            }
    
                            $courseCount = $courseCounts[$courseActive->id]; 
                            $totalCourses = $coursesActive->where('id', $courseActive->id)->count(); 
    
                            $students = DB::table('section')
                                        ->join('enrollment', 'section.id', '=', 'enrollment.section_id')
                                        ->join('user', 'enrollment.student_id', '=', 'user.id')
                                        ->select('user.*')
                                        ->where('section.instructor_id', '=', $instructor->id)
                                        ->where('enrollment.section_id', '=', $courseActive->idSection)
                                        ->get();
    
                            $studentData = []; 
                            foreach ($students as $student) {
                                $studentData[] = [
                                    'id' => $student->id,
                                    'name' => $student->name,
                                    'lastname' => $student->lastname,
                                ];
                            }
    
                            $days[] = [
                                'day' => $courseActive->day,
                                'coach_id' => $courseActive->coach_id,
                                'start_time' => $courseActive->start_time,
                                'end_time' => $courseActive->end_time,
                                'id' => $courseActive->id,
                                'idSession' => $courseActive->idSession,
                                'name_course' => $courseActive->name_course,
                                'name_user' => $courseActive->name_user,
                                'lastname' => $courseActive->lastname,
                                'countryName' => $courseActive->countryName,
                                'flag' => $courseActive->flag,
                                'session' => "$courseCount/$totalCourses",
                                'students' => $studentData, 
                            ];
                           
                            $courseCounts[$courseActive->id]++; 
                            
                        }
                        $idCoach = null;
                        $courseSelected = null;

                    $coachesActive = DB::table('coach_info')
                                    ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                                    ->join('section', 'session.course_id', '=', 'section.course_id')
                                    ->join('user','coach_info.user_id','=','user.id')
                                    ->join('country','user.country_id','=','country.id')
                                    ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                                    ->select('user.id', 'user.name', 'user.lastname', 'profile_image.filename as url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                                    ->where('section.instructor_id', '=', $instructor->id)
                                    ->where('section.course_id', '=', $course->id)
                                    ->distinct()
                                    ->get();     

               
                    return view('admin.course.schedule.section_schedule', compact('startOfWeek', 'days', 'coachesActive', 'course'));


            } elseif ($direction === 'back') {
                $startOfWeek->subWeek();
                Session::put('startOfWeek', $startOfWeek);
                
                $days = [];

                $courseCounts = [];
                        foreach ($coursesActive as $courseActive) {
                            if (!isset($courseCounts[$courseActive->id])) {
                                $courseCounts[$courseActive->id] = 1;
                            }
    
                            $courseCount = $courseCounts[$courseActive->id]; 
                            $totalCourses = $coursesActive->where('id', $courseActive->id)->count(); 
    
                            $students = DB::table('section')
                                        ->join('enrollment', 'section.id', '=', 'enrollment.section_id')
                                        ->join('user', 'enrollment.student_id', '=', 'user.id')
                                        ->select('user.*')
                                        ->where('section.instructor_id', '=', $instructor->id)
                                        ->where('enrollment.section_id', '=', $courseActive->idSection)
                                        ->get();
    
                            $studentData = []; 
                            foreach ($students as $student) {
                                $studentData[] = [
                                    'id' => $student->id,
                                    'name' => $student->name,
                                    'lastname' => $student->lastname,
                                ];
                            }
    
                            $days[] = [
                                'day' => $courseActive->day,
                                'coach_id' => $courseActive->coach_id,
                                'start_time' => $courseActive->start_time,
                                'end_time' => $courseActive->end_time,
                                'id' => $courseActive->id,
                                'idSession' => $courseActive->idSession,
                                'name_course' => $courseActive->name_course,
                                'name_user' => $courseActive->name_user,
                                'lastname' => $courseActive->lastname,
                                'countryName' => $courseActive->countryName,
                                'flag' => $courseActive->flag,
                                'session' => "$courseCount/$totalCourses",
                                'students' => $studentData, 
                            ];
                           
                            $courseCounts[$courseActive->id]++; 
                            
                        }
                        $idCoach = null;
                        $courseSelected = null;

                    $coachesActive = DB::table('coach_info')
                        ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                        ->join('section', 'session.course_id', '=', 'section.course_id')
                        ->join('user','coach_info.user_id','=','user.id')
                        ->join('country','user.country_id','=','country.id')
                        ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                        ->select('user.id', 'user.name', 'user.lastname', 'profile_image.filename as url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                        ->where('section.instructor_id', '=', $instructor->id)
                        ->where('section.course_id', '=', $course->id)
                        ->distinct()
                        ->get();     

              
                    return view('admin.course.schedule.section_schedule', compact('startOfWeek', 'days', 'coachesActive', 'course'));
            }
        
            Session::put('startOfWeek', $startOfWeek);
                
            $days = [];  
            if($request->has('coach_id')){
                if($request->coach_id == 0){
                    $idCoach = $request->coach_id;

                        $courseCounts = [];
                        $days = [];
                     
                    foreach ($coursesActive as $course) {
                        if (!isset($courseCounts[$course->id])) {
                            $courseCounts[$course->id] = 1;
                        }
                        
                        $courseCount = $courseCounts[$course->id]; 
                        $totalCourses = $coursesActive->where('id', $course->id)->count(); 

                        $students = DB::table('section')
                                    ->join('enrollment', 'section.id', '=', 'enrollment.section_id')
                                    ->join('user', 'enrollment.student_id', '=', 'user.id')
                                    ->select('user.*')
                                    ->where('section.instructor_id', '=', $instructor->id)
                                    ->where('enrollment.section_id', '=', $course->idSection)
                                    ->get();

                        $studentData = []; 
                        foreach ($students as $student) {
                            $studentData[] = [
                                'id' => $student->id,
                                'name' => $student->name,
                                'lastname' => $student->lastname,
                            ];
                        }
    
                            $days[] = [
                                'day' => $course->day,
                                'coach_id' => $course->coach_id,
                                'start_time' => $course->start_time,
                                'end_time' => $course->end_time,
                                'id' => $course->id,
                                'idSession' => $course->idSession,
                                'name_course' => $course->name_course,
                                'name_user' => $course->name_user,
                                'lastname' => $course->lastname,
                                'countryName' => $course->countryName,
                                'flag' => $course->flag,
                                'session' => "$courseCount/$totalCourses",
                                'students' => $studentData, 
                            ];
                        
                        
                        $courseCounts[$course->id]++; 

                    }
                  
                    $courseSelected = $request->coach_id;

                    $coachesActive = DB::table('coach_info')
                                    ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                                    ->join('section', 'session.course_id', '=', 'section.course_id')
                                    ->join('user','coach_info.user_id','=','user.id')
                                    ->join('country','user.country_id','=','country.id')
                                    ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                                    ->select('user.id', 'user.name', 'user.lastname', 'profile_image.filename as url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                                    ->where('section.instructor_id', '=', $instructor->id)
                                    ->where('section.course_id', '=', $course->id)
                                    ->distinct()
                                    ->get(); 
                       
                    return view('admin.course.schedule.section_schedule', compact('days', 'startOfWeek', 'courseSelected', 'coachesActive', 'course'));
    


                }else{
                    $idCoach = $request->coach_id;
           
                        $courseCounts = [];
                        $days = [];
                         
                        foreach ($coursesActive as $course) {
                            if (!isset($courseCounts[$course->id])) {
                                $courseCounts[$course->id] = 1;
                            }
                            
                            $courseCount = $courseCounts[$course->id]; 
                            $totalCourses = $coursesActive->where('id', $course->id)->count(); 
    
                            $students = DB::table('section')
                                        ->join('enrollment', 'section.id', '=', 'enrollment.section_id')
                                        ->join('user', 'enrollment.student_id', '=', 'user.id')
                                        ->select('user.*')
                                        ->where('section.instructor_id', '=', $instructor->id)
                                        ->where('enrollment.section_id', '=', $course->idSection)
                                        ->get();
   
                            $studentData = []; 
                            foreach ($students as $student) {
                                $studentData[] = [
                                    'id' => $student->id,
                                    'name' => $student->name,
                                    'lastname' => $student->lastname,
                                ];
                            }
    
                            if($course->coach_id == $request->coach_id){
                                
                                $days[] = [
                                    'day' => $course->day,
                                    'coach_id' => $course->coach_id,
                                    'start_time' => $course->start_time,
                                    'end_time' => $course->end_time,
                                    'id' => $course->id,
                                    'idSession' => $course->idSession,
                                    'name_course' => $course->name_course,
                                    'name_user' => $course->name_user,
                                    'lastname' => $course->lastname,
                                    'countryName' => $course->countryName,
                                    'flag' => $course->flag,
                                    'session' => "$courseCount/$totalCourses",
                                    'students' => $studentData, 
                                ];
                            }
                            
                            $courseCounts[$course->id]++; 

                        }
                      
                        $courseSelected = $request->coach_id;
                            
                        $coachesActive = DB::table('coach_info')
                                        ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                                        ->join('section', 'session.course_id', '=', 'section.course_id')
                                        ->join('user','coach_info.user_id','=','user.id')
                                        ->join('country','user.country_id','=','country.id')
                                        ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                                        ->select('user.id', 'user.name', 'user.lastname', 'profile_image.filename as url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                                        ->where('section.instructor_id', '=', $instructor->id)
                                        ->where('section.course_id', '=', $course->id)
                                        ->distinct()
                                        ->get(); 
                     
                        return view('admin.course.schedule.section_schedule', compact('days', 'startOfWeek', 'courseSelected', 'coachesActive', 'course'));
        
                }
            }
              
    
                        $courseCounts = [];
                        foreach ($coursesActive as $courseActive) {
                            if (!isset($courseCounts[$courseActive->id])) {
                                $courseCounts[$courseActive->id] = 1;
                            }
    
                            $courseCount = $courseCounts[$courseActive->id]; 
                            $totalCourses = $coursesActive->where('id', $courseActive->id)->count(); 
    
                            $students = DB::table('section')
                                        ->join('enrollment', 'section.id', '=', 'enrollment.section_id')
                                        ->join('user', 'enrollment.student_id', '=', 'user.id')
                                        ->select('user.*')
                                        ->where('section.instructor_id', '=', $instructor->id)
                                        ->where('enrollment.section_id', '=', $courseActive->idSection)
                                        ->get();
    
                            $studentData = []; 
                            foreach ($students as $student) {
                                $studentData[] = [
                                    'id' => $student->id,
                                    'name' => $student->name,
                                    'lastname' => $student->lastname,
                                ];
                            }
    
                            $days[] = [
                                'day' => $courseActive->day,
                                'coach_id' => $courseActive->coach_id,
                                'start_time' => $courseActive->start_time,
                                'end_time' => $courseActive->end_time,
                                'id' => $courseActive->id,
                                'idSession' => $courseActive->idSession,
                                'name_course' => $courseActive->name_course,
                                'name_user' => $courseActive->name_user,
                                'lastname' => $courseActive->lastname,
                                'countryName' => $courseActive->countryName,
                                'flag' => $courseActive->flag,
                                'session' => "$courseCount/$totalCourses",
                                'students' => $studentData, 
                            ];
                           
                            $courseCounts[$courseActive->id]++; 
                            
                        }
                        $idCoach = null;
                        $courseSelected = null;
                           
                        $coachesActive = DB::table('coach_info')
                                        ->join('session', 'coach_info.user_id', '=', 'session.coach_id')
                                        ->join('section', 'session.course_id', '=', 'section.course_id')
                                        ->join('user','coach_info.user_id','=','user.id')
                                        ->join('country','user.country_id','=','country.id')
                                        ->leftJoin('profile_image', 'user.id', '=', 'profile_image.user_id')
                                        ->select('user.id', 'user.name', 'user.lastname', 'profile_image.filename as url_photo', 'country.name as countryName', 'country.iso2 as flag', 'coach_info.url_video as video', 'coach_info.description as description')
                                        ->where('section.instructor_id', '=', $instructor->id)
                                        ->where('section.course_id', '=', $course->id)
                                        ->distinct()
                                        ->get();
                         
            view()->share([
                'canvas_id' => $canvas_id,
                'coaches' => $coaches,
                'course' => $course,
                'students' => $students,
                'guide' => $guideByDefault,
                'studentsInSection' => $studentsInSection,
                'linguaMoney' => new LinguaMoney(),
                'loadExpanderJs' => true,
                'reviewsStatsCollection' => $reviewsStatsCollection,
                'startOfWeek' => $startOfWeek,
                'days' => $days,
                'coachesActive' => $coachesActive,
                'timezone' => $this->userTimezone()
            ]);
           
            return view('instructor.course.show_tab');

        } catch (\Throwable $exception) {

            dd($exception);

            Log::error('There is an error when show course', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }

    private function configSchedule(Course $course)
    {

        if ($course->isFlex()) {
            $presenter = app(ScheduleFlexPresenter::class);
            $viewDataSchedule = $presenter->handle($course, user());
        } else {
            $presenter = app(ScheduleWeeksPresenter::class);
            $viewDataSchedule = $presenter->handle($course, user(), false, false);
        }

        $currentPeriod = $viewDataSchedule->periods()->nearToDate(Carbon::now());

        view()->share([
            'currentPeriod' => $currentPeriod,
            'page' => 1,
            'viewData' => $viewDataSchedule,
        ]);


        if ( ! $course->isFlex()) {

            if ($currentPeriod) {
                $paginator = new PaginatorPeriod($currentPeriod->get());
                view()->share([
                    'paginatorPeriod' => $paginator,
                    'periodKey' => '',
                ]);
            }
        }
    }

    private function configAssignments(Course $course)
    {

        $instructionsFinder = new InstructionsFinder();

        $presenter = $this->obtainPresenter($course);
        $viewDataSection = $presenter->handle($course);

        view()->share([
            'instructionsFinder' => $instructionsFinder,
            'isSmallGroup' => $course->conversationPackage->sessionType->isSmallGroup(),
            'viewDataSection' => $viewDataSection,
        ]);
    }

    private function obtainPresenter(Course $course)
    {

        if ($course->isFlex()) {

            if ($course->conversationPackage->sessionType->isSmallGroup()) {
                return app(SmallGroupFlexPresenter::class);
            }

            return app(OneOnOneFlexPresenter::class); //**
        }

        //course with coaching weeks...

        if ($course->conversationPackage->sessionType->isSmallGroup()) {
            return app(SmallGroupWeekPresenter::class);
        }

        return app(OneOnOneWeekPresenter::class);
    }

    private function obtainGuideByDefault(Course $course)
    {

        $guide = $course->conversationGuide;

        if ($guide->hasLingroWithoutGuide()) {
            return $this->guideRepository->obtainLinguameetingSpanish();

        }

        return $guide;
    }
}
