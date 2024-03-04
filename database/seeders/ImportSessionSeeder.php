<?php

namespace Database\Seeders;

use App\Src\_Old\Model\StudentsCoursesSessionsNew;
use App\Src\_Old\Model\StudentsFeedbacks;
use App\Src\_Old\Model\ZoomRecordings;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();

        $this->createStatusSession();

        //La nueva estructura de tablas hace que importar las sesiones no tenga sentido.
        //$this->importSession();

        DB::commit();

    }

    private function createStatusSession (){

        $status = new \App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus();
        $status->id = 1;
        $status->name ='Unspecified';
        $status->slug ='unspecified';
        $status->save();

        $status = new \App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus();
        $status->id = 2;
        $status->name ='Attendance';
        $status->slug ='attendance';
        $status->save();

        $status = new \App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus();
        $status->id = 3;
        $status->name ='Missed';
        $status->slug ='missed';
        $status->save();
    }

    private function importSession (){

        $students = $coach = User::query()
            ->role(config('linguameeting.user.roles.ids.student'))
            ->get();

        foreach ($students as $student){

            $sessionsOld = StudentsCoursesSessionsNew::where('id_student_session', $student->id)->orderBy('id_student_session')->get();

            if ($sessionsOld->count()){

                foreach ($sessionsOld as $sessionOld){

                    $coachingWeek = CoachingWeek::find($sessionOld->week_id);
                    $enrollment = Enrollment::find($sessionOld->enroll_id);
                    $coach = User::find($sessionOld->id_coach);

                    if ($coachingWeek AND $enrollment AND $coach){

                        //dd($coachingWeek, $enrollment, $sessionOld);

                        $session = new Session();
                        $session->id = $sessionOld->id_student_session;
                        $session->enrollment_id = $enrollment->id;
                        $session->coach_id = $coach->id;
                        $session->coaching_week_id = $coachingWeek->id;
                        $session->session_id_recovered = $sessionOld->session_recovered;

                        $session->session_id_recovered = null;
                        if ($sessionOld->session_recovered){
                            dd($sessionOld);
                        }

                        $session->session_order = $sessionOld->session_id;

                        $session->session_start = $sessionOld->date_select_ini;
                        $session->session_end = $sessionOld->date_select_end;
                        $timezone = TimeZone::where('name', $sessionOld->timezone)->first();
                        $session->timezone_id = $timezone->id;

                        $session->comments = $sessionOld->comments ?? '';

                        $session->attended_by_coach = null;
                        if ($sessionOld->date_select_ini->isPast()){

                            if ($sessionOld->not_attended_by_coach){
                                $session->attended_by_coach = false;
                            }
                            else{
                                $session->attended_by_coach = true;
                            }
                        }

                        if ($sessionOld->attendance == 1){
                            $session->session_status_id = 2;
                        }
                        elseif($sessionOld->missed == 1){
                            $session->session_status_id = 3;
                        }
                        else{
                            dd($sessionOld, $coachingWeek, 'past');
                        }

                        $session->save();

                        $this->importZoomRecording($sessionOld, $session);

                        $this->importFeedback($session);
                    }
                }
            }
        }
    }

    private function importZoomRecording ($sessionOld, $session){

        if ($sessionOld->id_recording){

            $old = ZoomRecordings::find($sessionOld->id_recording);

            $new = new ZoomRecording();
            $new->id = $old->id_recording;
            $new->uuid = $old->uuid ;
            $new->account_id = $old->account_id ;
            $new->recording_zoom_id = $old->id_recording_zoom ;
            $new->host_id = $old->host_id ;
            $new->start = $old->recording_start ;
            $new->end = $old->recording_end ;
            $new->timezone = $old->timezone ;
            $new->file_type = $old->file_type ;
            $new->play_url = $old->play_url ;
            $new->download_url = $old->download_url;
            $new->chat_file = $old->chat_file;
            $new->status = $old->status;

            $new->save();

            $session->zoom_recording_id = $new->id;
            $session->save();
        }
    }

    private function importFeedback($session){

        $old = StudentsFeedbacks::where('id_student_course_session', $session->id)->first();

        if ($old){

            $feedback = new StudentReview();
            $feedback->id = $old->id_feedback;
            $feedback->session_id = $session->id;
            $feedback->participation_type_id = $old->id_participation;
            $feedback->prepared_class_type_id = $old->id_prepared;
            $feedback->puntuality_type_id = $old->id_puntuality;
            $feedback->is_puntual_session = $old->is_puntual_session;
            $feedback->observations = $old->observations;

            $feedback->save();
        }
    }
}
