<?php

namespace App\Http\Controllers\Api\Student\Calendar\Event;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Calendar\Presenter\CalendarEventByDayPresenter;
use App\Src\StudentDomain\Calendar\Presenter\CalendarSetup;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;


class GetEventController extends Controller
{

    public function __invoke(User $student, string $startDate, string $endDate, string $gridType = 'dayGridMonth')
    {
        try {

            //configuramos el período para buscar la disponiblidad en el calendario en el timezone del usuario ya que el inicio y final del
            //período mostrado depende del timezone
            $startDate = Carbon::parse($startDate, userTimezoneName())->startOfDay()->clone()->setTimezone('UTC');
            $endDate = Carbon::parse($endDate, userTimezoneName())->endOfDay()->setTimezone('UTC');
            $period = new CarbonPeriod($startDate, $endDate);

            $calendarSetup = new CalendarSetup($gridType);
            $presenter = app(CalendarEventByDayPresenter::class);
            $scheduleResponse = $presenter->handle($student, $period, $calendarSetup);

            return response()->json(['events' => json_encode($scheduleResponse->events())]);

        } catch (\Throwable $exception) {

            return response()->json(['message' => 'Failed to get calendar events '], 500);
        }
    }
}
