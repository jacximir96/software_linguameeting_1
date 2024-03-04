<?php
namespace App\Src\StudentDomain\Enrollment\Presenter;

use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Repository\PaymentRepository;
use App\Src\PaymentDomain\PaymentDetail\Service\PaymentDetailFinder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Collection;


class EnrollmentPresenter
{
    private OptionsGroup $optionsGroup;

    private PaymentDetailFinder $paymentDetailFinder;

    private PaymentRepository $paymentRepository;

    public function __construct(OptionsGroup $optionsGroup, PaymentDetailFinder $paymentDetailFinder, PaymentRepository $paymentRepository)
    {
        $this->optionsGroup = $optionsGroup;
        $this->paymentDetailFinder = $paymentDetailFinder;
        $this->paymentRepository = $paymentRepository;
    }

    public function handle(Enrollment $enrollment): EnrollmentResponse
    {

        $otherSessionsAvailable = $this->obtainOtherSessionsAvailable($enrollment);

        $this->optionsGroup->configOptions();

        $payment = $this->obtainPayment($enrollment);

        return new EnrollmentResponse($enrollment, $payment, $otherSessionsAvailable, $this->optionsGroup);
    }

    private function obtainOtherSessionsAvailable(Enrollment $enrollment): Collection
    {

        $sessions = collect();

        foreach ($enrollment->makeup as $makeup) {

            $item = new ExtraSession($makeup);
            $sessions->add($item);
        }

        foreach ($enrollment->extraSession as $extraSession) {
            $item = new ExtraSession($extraSession);
            $sessions->add($item);
        }

        return $sessions->sortByDesc(function ($session) {
            return $session->moment()->toDateTimeString();
        });
    }

    public function obtainPayment (Enrollment $enrollment):Payment{

        $paymentDetail = $this->paymentDetailFinder->findPaymentDetailByEnrollment($enrollment);

        $payment = $paymentDetail->payment;

        $payment->load($this->paymentRepository->relations());

        return $payment;
    }
}
