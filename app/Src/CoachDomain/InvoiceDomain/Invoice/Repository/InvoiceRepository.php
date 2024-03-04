<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Repository;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class InvoiceRepository
{
    public function obtainByCoach(User $coach)
    {

        return Invoice::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    public function obtainByCoachAndMonth(User $coach, Month $month)
    {

        return Invoice::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->where('month', $month->month())
            ->where('year', $month->year())
            ->first();
    }

    public function obtainLastFromCoach(User $coach)
    {

        return Invoice::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->first();
    }

    public function relations(): array
    {
        return [
            'detail',
        ];
    }
}
