<?php

namespace App\Http\Controllers\Coach\Schedule\Availability;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachSchedule\Action\DeleteForOneDayAction;
use App\Src\CoachDomain\CoachSchedule\Action\DeleteForPeriodAction;
use App\Src\CoachDomain\CoachSchedule\Action\DeleteForSamedayWeekAction;
use App\Src\CoachDomain\CoachSchedule\Action\UpdateForOneDayAction;
use App\Src\CoachDomain\CoachSchedule\Action\UpdateForPeriodAction;
use App\Src\CoachDomain\CoachSchedule\Action\UpdateForSameDayWeekAction;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\AvailabilityForm;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditController extends Controller
{
    public function configView(User $coach, string $date, string $startTime, string $endTime)
    {
        $date = Carbon::parse($date);
        $originalSlot = DateSlot::fromDateAndTimes($date, $startTime, $endTime);//utc
        $timezone = TimeZoneRepository::findByName($coach->timezonename());

        $form = app(AvailabilityForm::class);
        $form->configToEdit($coach, $originalSlot, $timezone);

        view()->share([
            'coach' => $coach,
            'date' => $originalSlot->start(),
            'form' => $form,
            'slot' => $originalSlot,
        ]);

        return view('admin.coach.schedule.availability.form');
    }

    public function update(CoachScheduleRequest $request, User $coach, string $date, string $startTime, string $endTime)
    {
        try {
            //lo que queremos actualizar (url - utc)
            $date = Carbon::parse($date);
            $originalSlots = DateSlot::fromDateAndTimes($date, $startTime, $endTime);

            //los valores que queremos actualizar (formulario)
            $dateTimezone = Carbon::parse($date->toDateString().' '.$startTime)->setTimezone(userTimezoneName());
            $finalSlots = SlotsUtc::convertSlotsRequestsToUtc($dateTimezone,  $request->start_time, $request->end_time);

            DB::beginTransaction();

            if ($request->isUpdate()){
                $this->runUpdate($request, $coach, $originalSlots, $finalSlots);
            }
            elseif($request->isDelete()){
                $this->runDelete($request, $coach, $originalSlots);
            }

            DB::commit();

            return view('common.feedback_modal');

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create coach', [
                'request' => $request,
                'coach' => $coach,
                'date' => $date,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'exception' => $exception,
            ]);

            flash(trans('coach.availability.update.error.on_update'))->error();

            return back();
        }
    }

    private function runUpdate (CoachScheduleRequest $request, User $coach, DateSlot $originalSlots, SlotsUtc $finalSlots){

        if ($request->isApplyToDay()){
            $action = app(UpdateForOneDayAction::class);
            $action->handle($request, $coach, $originalSlots, $finalSlots);
        }
        elseif($request->isApplyToSameDayWeek()){

            $timezone = TimeZoneRepository::findByName(userTimezoneName());
            $period = $request->periodFromTimezone($timezone);

            $action = app(UpdateForSameDayWeekAction::class);
            $action->handle($request, $coach, $period, $originalSlots, $finalSlots);
        }
        elseif ($request->isApplyToPeriod()){

            $timezone = TimeZoneRepository::findByName(userTimezoneName());
            $period = $request->periodFromTimezone($timezone);

            $action = app(UpdateForPeriodAction::class);
            $action->handle($request, $coach, $period, $originalSlots, $finalSlots);
        }

        flash(trans('coach.availability.update.success'))->success();

    }

    /**
     * @param CoachScheduleRequest $request
     * @param User $coach
     * @param DateSlot $slot  este $slot es el creado a partir de la url por eso ya viene en utc. Además, es el rango completo seleccionado
     * @throws \Exception
     */
    private function runDelete (CoachScheduleRequest $request, User $coach, DateSlot $slot){

        if ($request->isApplyToDay()){
            $action = app(DeleteForOneDayAction::class);
            $action->handle($coach, $slot);
        }
        elseif($request->isApplyToSameDayWeek()){
            $action = app(DeleteForSamedayWeekAction::class);
            $action->handle($request, $coach, $slot);
        }
        elseif ($request->isApplyToPeriod()){
            $action = app(DeleteForPeriodAction::class);
            $action->handle($request, $coach, $slot);
        }

        flash(trans('coach.availability.delete.success'))->success();
    }
}
