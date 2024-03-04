<?php

namespace App\Http\Controllers\Coach\Schedule\Availability;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachSchedule\Action\CreateForOneDayAction;
use App\Src\CoachDomain\CoachSchedule\Action\CreateForPeriodAction;
use App\Src\CoachDomain\CoachSchedule\Action\CreateForSameDayWeekAction;
use App\Src\CoachDomain\CoachSchedule\Exception\ExistingAvailability;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\AvailabilityForm;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    public function configView(User $coach, string $date)
    {
        $date = Carbon::parse($date, $coach->timezone->name);

        $form = app(AvailabilityForm::class);
        $form->configToCreate($coach, $date);

        view()->share([
            'coach' => $coach,
            'date' => $date,
            'form' => $form,
        ]);

        return view('admin.coach.schedule.availability.form');
    }

    public function create(CoachScheduleRequest $request, User $coach, string $date)
    {
        try {

            $date = Carbon::parse($date, $coach->timezone->name);

            if ($request->isApplyToDay()){
                $slotsUtc = SlotsUtc::convertSlotsRequestsToUtc($date, $request->start_time, $request->end_time);
                $action = app(CreateForOneDayAction::class);
                $action->handle($request, $coach, $slotsUtc);
            }
            elseif($request->isApplyToSameDayWeek()){
                $timezone = TimeZoneRepository::findByName(userTimezoneName());
                $action = app(CreateForSameDayWeekAction::class);
                $action->handle($request, $coach, $timezone);
            }
            elseif($request->isApplyToPeriod()){
                $timezone = TimeZoneRepository::findByName(userTimezoneName());
                $action = app(CreateForPeriodAction::class);
                $action->handle($request, $coach, $timezone);
            }

            DB::commit();

            flash(trans('coach.availability.create.success'))->success();

            return redirect()->route('get.coach.schedule.availability.create', [$coach->hashId(), $date->toDateString()]);

        }
        catch (ExistingAvailability $existingAvailability){

            flash(trans('coach.availability.create.error.availability_existing'))->error();

            return back();

        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create availability for coach', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.availability.create.error.on_create'))->error();

            return back();
        }
    }
}
