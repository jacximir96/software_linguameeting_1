<?php

namespace Database\Seeders;

use App\Src\_Old\Model\CoachScheduleNew;
use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportCoachScheduleSeeder extends Seeder
{
    use TraitImport;

    private $timezoneRepository;

    public function run()
    {
        $this->truncate('coach_schedule');

        $this->timezoneRepository = app(TimeZoneRepository::class);

        $coaches = User::role(config('linguameeting.user.roles.coach'))->orderBy('id')->take(2)->get();
        $coaches = User::whereIn('id', [165])->get();

        foreach ($coaches as $coach) {
            if ($coach->active) {
                $this->importSchedule($coach);
            }
        }
    }

    private function importSchedule(User $coach)
    {

        CoachScheduleNew::where('coach_id', $coach->id)
            ->orderBy('schedule_id')
            ->chunk(1000, function ($schedule) use ($coach) {

                dump($coach->name, $schedule->count());

                foreach ($schedule as $old) {

                    $new = new CoachSchedule();
                    $new->id = $old->schedule_id;
                    $new->coach_id = $coach->id;
                    $new->day = Carbon::parse($old->schedule_date);
                    $new->start_time = $old->time_from_schedule;
                    $new->end_time = $old->time_to_schedule;
                    $new->day_of_week = $old->dayOfWeek();

                    /*
                    if ($old->course_id) {
                        $course = Course::find($old->course_id);
                        if (is_null($course)) {
                            return;
                        }

                        $new->course_id = $old->course_id;
                    }
                    */
                    $timezone = $this->timezoneRepository->findTimezoneByNameOrNull($old->time_zone);
                    $new->timezone_id = $timezone->id;


                    $new->blocked_ses = $old->blocked_ses;
                    //$new->actual_occ = $old->actual_occ;
                    //$new->occ_max = $old->occ_max;
                    //$new->attended = $old->attended;
                    $new->save();
                }
            });
    }
}
