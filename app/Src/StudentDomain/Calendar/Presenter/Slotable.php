<?php

namespace App\Src\StudentDomain\Calendar\Presenter;

use App\Src\StudentDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;

trait Slotable
{
    protected function createSlot(Session $session, $date, bool|int $horaInicio, bool|int $horaFin): array
    {
        $currentSlot = [
            'course_id' => $session->course_id,
            'date' => $date,
            'date_carbon' => $session->day,
            'start_hour' => date('H:i', $horaInicio),
            'end_hour' => date('H:i', $horaFin),
            'blocked_ses' => false,
            'session' => [
                'id' => $session->id,
                'hashId' => $session->hashId(),
                'occupation' => [
                    'current_registered' => $session->occupation()->currentRegistered(),
                    'total_allowed' => $session->occupation()->totalAllowed(),
                ],
                'session_type' => [
                    'code' => $session->course->conversationPackage->sessionType->code,
                ],
                'flex' => $session->course->isFlex(),
            ],
            'reservedInfo' => [
                'course' => [
                    'id' => $session->course_id,
                    'name' => $session->course->name,
                    'color' => $session->course->color,
                ],
                'university' => [
                    'id' => $session->course->university->id,
                    'name' => $session->course->university->name,
                ],
            ],
        ];

        return $currentSlot;
    }
}
