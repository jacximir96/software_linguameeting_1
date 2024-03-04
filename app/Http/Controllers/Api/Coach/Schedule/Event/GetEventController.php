<?php

namespace App\Http\Controllers\Api\Coach\Schedule\Event;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachSchedule\Presenter\CalendarEventByMonthPresenter;
use App\Src\CoachDomain\CoachSchedule\Presenter\CalendarEventByWeekPresenter;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;


class GetEventController extends Controller
{

    public function __invoke(User $coach, string $startDate, string $endDate, string $gridType = 'dayGridMonth')
    {
        try {

            //configuramos el período para buscar la disponiblidad en el calendario en el timezone del usuario ya que el inicio y final del
            //período mostrado depende del timezone
            $startDate = Carbon::parse($startDate, userTimezoneName())->startOfDay();
            $endDate = Carbon::parse($endDate, userTimezoneName())->endOfDay();
            $period = new CarbonPeriod($startDate, $endDate);

            $slotsUtc = SlotsUtc::convertPeriodToUtc($period);
            $timezone = $coach->timezone;



            if ($gridType == 'dayGridMonth'){
                $presenter = app(CalendarEventByMonthPresenter::class);
                $scheduleResponse = $presenter->handle(user(), $coach, $slotsUtc, $timezone);
            }
            else{
                $presenter = app(CalendarEventByWeekPresenter::class);
                $scheduleResponse = $presenter->handle($coach, $slotsUtc, $timezone);
            }

            return response()->json(['events' => json_encode($scheduleResponse->events())]);

        } catch (\Throwable $exception) {

            Log::error('Error while obtain coach availability',[
                'coach' => $coach,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'gridType' => $gridType
            ]);

            return response()->json(['message' => 'Failed to get calendar events '], 500);
        }
    }
}
