<?php

namespace App\Src\CoachDomain\CoachSchedule\Service;

use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class AvailabilityForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private $startTimeSlots = [];

    private $endTimeSlots = [];

    private CoachScheduleRepository $coachScheduleRepository;

    public function __construct(FieldFormBuilder $fieldFormBuilder, CoachScheduleRepository $coachScheduleRepository)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    //$date con el timezone de destino
    public function configToCreate(User $coach, Carbon $date)
    {
        $this->action = route('post.coach.schedule.availability.create', [$coach->hashId(), $date->toDateString()]);

        $this->model = [];

        $this->slots = $this->configSlots();
    }

    public function configToEdit(User $coach, DateSlot $originalSlot, TimeZone $finalTimeZone)
    {
        $this->isEdit = true;

        $this->action = route('post.coach.schedule.availability.update', [$coach->hashId(), $originalSlot->start()->toDateString(), $originalSlot->start()->toTimeString(), $originalSlot->end()->toTimeString()]);

        $this->configSlots();

        $this->model['start_time'] = $originalSlot->start()->clone()->setTimezone($finalTimeZone->name)->format('H:i');
        $this->model['end_time'] = $originalSlot->end()->clone()->addMinute()->setTimezone($finalTimeZone->name)->format('H:i');

        if ($this->model['end_time'] == '00:00'){
            $this->model['end_time'] = '23:59';
        }

        $first = $this->coachScheduleRepository->findSession($coach, $originalSlot->start());

        if ($first->isBlocked()) {
            $this->model['apply_hours_off'] = true;
        }
    }

    private function configSlots()
    {

        $this->startTimeSlots = $this->fieldFormBuilder->obtainAvailabilitySlotsTime(30);

        $this->endTimeSlots = $this->fieldFormBuilder->obtainAvailabilitySlotsTime(30);

        unset($this->endTimeSlots['00:00']);
        $this->endTimeSlots['23:59'] = '23:59';
    }
}
