<?php

namespace Database\Seeders;

use App\Src\_Old\Model\CoursesCoaches;
use App\Src\_Old\Model\CoursesCoordinators;
use App\Src\_Old\Model\CoursesDocumentation;
use App\Src\_Old\Model\CoursesDuedates;
use App\Src\_Old\Model\CoursesNew;
use App\Src\_Old\Model\CoursesSectionsNew;
use App\Src\_Old\Model\CourseType;
use App\Src\_Old\Model\TeachersCourseCoor;
use App\Src\ConversationPackageDomain\PackageOffer\Model\ConversationPackageOffer;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\CourseDomain\ServiceType\Model\ServiceType;
use App\Src\CourseDomain\DenyAccess\Model\DenyAccess;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Holiday\Model\Holiday;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\ExperienceDomain\ExperienceType\Model\ExperienceType;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportCourseSeeder extends Seeder
{

    use TraitImport;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();

        $this->createSessionType();

        $this->createServiceType();

        $this->createExperienceType();

        $this->importConversationPackage();

        $this->importConversationPackageOffer();

        $this->importCourses();

        $this->importTeachingAssistantSection();

        DB::commit();
    }

    private function createSessionType()
    {
        $items = [
            ['id' => 1, 'name' => 'One-on-one', 'code' => 'O'],
            ['id' => 2, 'name' => 'Small Groups', 'code' => 'SG'],
            ['id' => 3, 'name' => 'None', 'code' => 'N']
        ];

        foreach ($items as $item) {

            $newItem = new SessionType();
            $newItem->id = $item['id'];
            $newItem->name = $item['name'];
            $newItem->code = $item['code'];
            $newItem->save();
        }
    }

    private function createServiceType (){

        $newItem = new ServiceType();
        $newItem->id = 1;
        $newItem->name = 'LinguaMeeting Conversations';
        $newItem->name_short = 'Conversations';
        $newItem->slug = 'conversations';
        $newItem->save();

        $newItem = new ServiceType();
        $newItem->id = 2;
        $newItem->name = 'Live Experiences';
        $newItem->name_short = 'Experiences';
        $newItem->slug = 'experiences';
        $newItem->save();

        $newItem = new ServiceType();
        $newItem->id = 3;
        $newItem->name = 'LinguaMeeting + experiences';
        $newItem->name_short = 'Combined';
        $newItem->slug = 'combined';
        $newItem->save();
    }

    private function createExperienceType (){

        $linguaMoney = new LinguaMoney();

        $newItem = new ExperienceType();
        $newItem->id = 1;
        $newItem->name = '1 Experience';
        $newItem->price = $linguaMoney->buildFromFloat(5);
        $newItem->num_experiences = 1;
        $newItem->is_unlimited = false;
        $newItem->save();

        $newItem = new ExperienceType();
        $newItem->id = 2;
        $newItem->name = '2 Experiences';
        $newItem->price = $linguaMoney->buildFromFloat(10);
        $newItem->num_experiences = 2;
        $newItem->is_unlimited = false;
        $newItem->save();

        $newItem = new ExperienceType();
        $newItem->id = 3;
        $newItem->name = 'Unlimited Experiences';
        $newItem->price = $linguaMoney->buildFromFloat(15);
        $newItem->num_experiences = null;
        $newItem->is_unlimited = true;
        $newItem->save();

    }

    private function importConversationPackage (){

        $linguaMoney = new LinguaMoney();

        $oldItems = CourseType::orderBy('id_type_course', 'asc')->get();

        foreach ($oldItems as $oldItem){

            $newItem = new \App\Src\ConversationPackageDomain\Package\Model\ConversationPackage();
            $newItem->id = $oldItem->id_type_course;

            $newItem->session_type_id = match ($oldItem->type_group){
                'O' => 1,
                'SG' => 2,
                'N' => 3,
                default => null,
            };

            if (is_null($newItem->session_type_id)){
                dd($newItem, $oldItem);
            }

            $newItem->name = $oldItem->name_type_course;
            $newItem->number_session = $oldItem->sessions_type_course;
            $newItem->duration_session = $oldItem->sessions_duration;
            $newItem->isbn = $oldItem->isbn;

            $newItem->experiences = $oldItem->experiences ;
            $newItem->make_up = $oldItem->make_up ;
            $newItem->hight_school = $oldItem->hight_school ;
            $newItem->code_active = $oldItem->code_active ;

            $price = $linguaMoney->buildFromFloat($oldItem->price);
            $newItem->price = $price;

            $newItem->save();
        }
    }

    private function importConversationPackageOffer (){

        $linguaMoney = new LinguaMoney();

        $oldItems = \App\Src\_Old\Model\CourseTypeOffer::orderBy('id_type_course_offer', 'asc')->get();

        foreach ($oldItems as $oldItem){

            $newItem = new ConversationPackageOffer();
            //este no lleva id;

            $newItem->session_type_id = match ($oldItem->type_group){
                'O' => 1,
                'SG' => 2,
                'N' => 3,
                default => null,
            };

            $newItem->name = $oldItem->name_type_course;
            $newItem->number_session = $oldItem->sessions_type_course;
            $newItem->duration_session = $oldItem->sessions_duration;
            $newItem->isbn = $oldItem->isbn;

            $newItem->make_up = $oldItem->make_up ;

            $price = $linguaMoney->buildFromFloat($oldItem->price);
            $newItem->price = $price;

            $newItem->save();
        }
    }

    private function importCourses (){

        $linguaMoney = new LinguaMoney();

        $oldItems = CoursesNew::orderBy('course_id', 'asc')->get();

        foreach ($oldItems as $oldItem){

            $newItem = new Course();
            $newItem->service_type_id = 1;
            $newItem->id = $oldItem->course_id;
            $newItem->university_id = $oldItem->id_university;
            $newItem->language_id = $oldItem->id_language;
            $newItem->conversation_package_id = $oldItem->id_type_course;
            $newItem->semester_id = $oldItem->semester_id;
            $newItem->level_id = $oldItem->level_id;
            $newItem->conversation_guide_id = $oldItem->textbook;

            /*
            $creatorEmail = $oldItem->created_by;
            $userCreator = User::where('email', $creatorEmail)->first();
            if (is_null($userCreator)){
                continue;
            }
            $newItem->creator_id = $userCreator->id;
            */

            $newItem->name = $oldItem->name_course;
            $newItem->student_class = $oldItem->students_class;
            $newItem->duration = $oldItem->duration_course;
            $newItem->year = $oldItem->year;
            $newItem->start_date = $oldItem->date_ini_course;
            $newItem->end_date = $oldItem->date_end_course;
            $newItem->description = $oldItem->description;
            $newItem->internal_comment = $oldItem->internal_comment;

            $newItem->is_free = $oldItem->free_course;
            $newItem->url_survey = $oldItem->url_survey;
            $newItem->is_lingro = $oldItem->conversation_guides;

            $newItem->color = $oldItem->color;
            $newItem->buy_makeups = $oldItem->buy_makeups;
            $newItem->number_makeups = $oldItem->number_makeups;
            $newItem->coaches_assigned = $oldItem->coaches_assigned;
            $newItem->complimentary_makeup = $oldItem->complimentary_makeup;
            $newItem->is_blocked_admin = $oldItem->blocked_admin;
            $newItem->is_flex = $oldItem->is_flex;

            $newItem->closed_date = $oldItem->date_closed;

            if ( ! is_null($oldItem->discount_value)){

                if ( ! $oldItem->discount_value){
                    $discount = $linguaMoney->buildZero();
                }
                else{
                    $discount = $linguaMoney->buildFromFloat($oldItem->discount_value);
                }

                $newItem->discount = $discount;
            }

            $newItem->created_at = $oldItem->created ? Carbon::parse($oldItem->created, 'Europe/Madrid')->setTimezone('UTC') : null;
            $newItem->updated_at = $oldItem->modified ? Carbon::parse($oldItem->modified, 'Europe/Madrid')->setTimezone('UTC') : null;
            $newItem->save();

            //holidays
            if (is_string($oldItem->days_holiday)) {

                if ( ! empty($oldItem->days_holiday)) {

                    $holidays = str_replace(' ', '', $oldItem->days_holiday);

                    $days = explode(',', $holidays);

                    foreach ($days as $day) {

                        if (empty($day)) {
                            dd($oldItem, $days, $day);
                        }

                        $holiday = new Holiday();
                        $holiday->course_id = $newItem->id;
                        $holiday->date = $day;
                        $holiday->save();
                    }
                }
            }

            /********** coaches *************/
            $coaches = CoursesCoaches::where('course_id', $oldItem->course_id)->orderBy('id_coach')->get();

            foreach ($coaches as $coach){

                $user = User::find($coach->id_coach);

                //todo remove check when all users are migrated
                if (is_null($user)){
                    continue;
                }

                $new = new CourseCoach();
                $new->course_id = $oldItem->course_id;
                $new->coach_id = $user->id;
                $new->save();
            }

            /********** course coordinators *************/
            $teachersCourseCoor = TeachersCourseCoor::where('course_id', $oldItem->course_id)->orderBy('course_id')->get();

            foreach ($teachersCourseCoor as $oldTeacherCourseCoor){

                $user = User::find($oldTeacherCourseCoor->course_coor_id);

                //todo remove check when all users are migrated
                if (is_null($user)){
                    continue;
                }

                $new = new CourseCoordinator();
                $new->course_id = $oldItem->course_id;
                $new->coordinator_id = $user->id;
                $new->save();
            }

            /********** coordinators bloqueados a cursos *************/
            $coordinators = CoursesCoordinators::where('id_course', $oldItem->course_id)->orderBy('id_coor')->get();

            foreach ($coordinators as $oldCoordinator){

                $user = User::find($oldCoordinator->id_coor);

                //todo remove check when all users are migrated
                if (is_null($user)){
                    continue;
                }

                if ( ! $oldCoordinator->see_course){

                    $deny = new DenyAccess();
                    $deny->user_id = $user->id;
                    $deny->course_id = $oldItem->course_id;
                    $deny->save();

                }
            }

            /********** coaching week *************/
            $oldsDuedates = CoursesDuedates::where('course_id', $oldItem->course_id)->orderBy('week_id', 'asc')->get();

            foreach ($oldsDuedates as $oldDuedates){

                $new = new CoachingWeek();
                $new->id = $oldDuedates->week_id;
                $new->course_id = $oldItem->course_id;
                $new->session_order = $oldDuedates->order_week;
                $new->occupation_week = $oldDuedates->week_occ;
                $new->start_date = $oldDuedates->date_start;
                $new->end_date = $oldDuedates->date_end;
                $new->is_makeup = $oldDuedates->is_makeUp;

                $new->save();
            }

            /********** sections *************/
            $oldSections = CoursesSectionsNew::where('course_id', $oldItem->course_id)->orderBy('section_id', 'asc')->get();
            foreach ($oldSections as $oldSection){

                $user = User::find($oldSection->id_teacher);

                //todo remove check when all users are migrated
                if (is_null($user)){
                    continue;
                }

                $new = new Section();
                $new->id = $oldSection->section_id;
                $new->course_id = $oldItem->course_id;
                $new->instructor_id = $user->id;

                if (is_int($oldSection->textbook_section) AND $oldSection->textbook_section > 0){
                    $new->conversation_guide_id = $oldSection->textbook_section;
                }


                $new->name = $oldSection->name_section;
                $new->num_students = $oldSection->students_section;
                $new->code = $oldSection->code;
                $new->see_recordings = $oldSection->see_recordings_students ?? false;
                $new->lingro_code = $oldSection->code_lingro;
                $new->make_ups_inst_section = $oldSection->make_ups_inst_section ?? 0 ;
                $new->make_ups_inst_section_used = $oldSection->make_ups_inst_section_used ?? 0 ;
                $new->is_free = $oldSection->free_section ?? false;

                $new->save();

                /****** documentation ******/
                $oldsDocumentation = CoursesDocumentation::where('id_section', $oldSection->section_id)->orderBy('id_documentation', 'asc')->get();

                foreach ($oldsDocumentation as $oldDocumentation){

                    try{

                        if ($oldDocumentation->id_week){
                            $coachingWeek = CoachingWeek::find($oldDocumentation->id_week);

                            if (is_null($coachingWeek)){
                                continue;
                            }

                            if ($coachingWeek->isMakeup()){
                                continue;
                            }
                        }

                        $new = new Assignment();
                        $new->id = $oldDocumentation->id_documentation;
                        $new->section_id = $oldDocumentation->id_section;

                        $isFlex = $oldDocumentation->id_chapter > 0;

                        if ($isFlex){
                            $new->session_order = $oldDocumentation->id_chapter;
                        }
                        else{
                            $new->week_id = $oldDocumentation->id_week;
                        }

                        $new->coach_note = $oldDocumentation->instructions_coaches;

                        if ( ! $oldDocumentation->share_only_coaches){
                            $new->activity_description = $oldDocumentation->instructions_coaches;
                        }

                        $new->save();

                        $isCustomAssignment = !is_null($oldDocumentation->assignment);

                        if ( ! $isCustomAssignment){
                            //save chapters
                            if (is_string($oldDocumentation->ids_chapters)){

                                $chaptersIds = trim($oldDocumentation->ids_chapters);

                                $chaptersIds = explode(',', $chaptersIds);

                                foreach ($chaptersIds as $chapterId){

                                    //todo remove
                                    if ($chapterId == 0){
                                        continue;
                                    }

                                    $assignmentChapter = new AssignmentChapter();
                                    $assignmentChapter->assignment_id = $new->id;
                                    $assignmentChapter->chapter_id = $chapterId;
                                    $assignmentChapter->save();
                                }
                            }
                        }
                        else{

                            $file = new AssignmentFile();
                            $file->id = $oldDocumentation->id_documentation;
                            $file->assignment_id = $new->id;
                            $file->filename = $oldDocumentation->assignment;
                            $file->original_name = basename ($oldDocumentation->assignment);

                            $pathInfo = pathInfo($oldDocumentation->assignment);

                            if ($pathInfo['extension'] == '...'){
                                dd($oldDocumentation);
                            }

                            $file->mime = $this->obtainMime($pathInfo['extension']);

                            $file->save();

                            $section = $file->assignment->section;
                            $section->save();
                        }

                    }
                    catch (\Throwable $exception){
                        dd($exception, $oldDocumentation, $new);
                    }

                }
            }
        }
    }

    private function importTeachingAssistantSection (){

        $map = collect();

        $map[] = ['teacher_id' => 79477, 'section_id' => 3457];
        $map[] = ['teacher_id' => 79481, 'section_id' => 3458];
        $map[] = ['teacher_id' => 83624, 'section_id' => 3090];
        $map[] = ['teacher_id' => 83624, 'section_id' => 3091];
        $map[] = ['teacher_id' => 91342, 'section_id' => 3099];
        $map[] = ['teacher_id' => 95131, 'section_id' => 2496];

        foreach ($map as $relation){

            $teacher = User::find($relation['teacher_id']);

            if (is_null($teacher)){
                continue;
            }

            $section = Section::find($relation['section_id']);

            if (is_null($section)){
                continue;
            }

            $item = new SectionTeachingAssistant();
            $item->section_id = $relation['section_id'];
            $item->teacher_id = $relation['teacher_id'];
            $item->save();

        }
    }
}
