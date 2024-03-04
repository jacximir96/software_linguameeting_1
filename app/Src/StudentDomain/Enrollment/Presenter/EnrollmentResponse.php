<?php

namespace App\Src\StudentDomain\Enrollment\Presenter;

use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Collection;

class EnrollmentResponse
{
    private Enrollment $enrollment;

    private Payment $payment;

    private Collection $otherSessionsAvailable;

    private OptionsGroup $optionsGroup;

    public function __construct(Enrollment $enrollment, Payment $payment, Collection $otherSessionsAvailable, OptionsGroup $optionsGroup)
    {
        $this->enrollment = $enrollment;
        $this->payment = $payment;
        $this->otherSessionsAvailable = $otherSessionsAvailable;
        $this->optionsGroup = $optionsGroup;
    }

    public function enrollment(): Enrollment
    {
        return $this->enrollment;
    }

    public function payment(): Payment
    {
        return $this->payment;
    }

    public function otherSessionsAvailable(): Collection
    {
        return $this->otherSessionsAvailable;
    }

    public function optionsGroup(): OptionsGroup
    {
        return $this->optionsGroup;
    }
}
