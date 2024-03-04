<?php

namespace App\Src\StudentDomain\Enrollment\Action;

use App\Src\CourseDomain\Course\Exception\CourseHasStarted;
use App\Src\CourseDomain\Course\Exception\CourseStartsSoon;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\EnrollmentWithSessions;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\PaymentDomain\Payment\Exception\TransactionIdIsEmpty;
use App\Src\PaymentDomain\Payment\Exception\PaymentNotExists;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\PaymentDomain\PaymentRefund\Action\Command\CreateRefundCommand;
use App\Src\PaymentDomain\PaymentRefund\Model\PaymentRefund;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentIsNotActive;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreditCardRefundAction
{
    //construct
    private EnrollmentSessionRepository $enrollmentSessionRepository;

    //status
    private Enrollment $enrollment;

    private PaymentDetail $paymentDetailToRefund;

    private User $user;

    private CreateRefundCommand $createRefundCommand;

    public function __construct(EnrollmentSessionRepository $enrollmentSessionRepository, CreateRefundCommand $createRefundCommand)
    {
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->createRefundCommand = $createRefundCommand;
    }

    public function handle(Enrollment $enrollment, PaymentDetail $paymentDetailToRefund, User $user): PaymentRefund
    {
        $this->initialize($enrollment, $paymentDetailToRefund, $user);

        $this->checkEnrollmentIsActive();

        $this->checkCourseHasNotStarted();

        $this->checkPaymentHasTransactionId();

        return $this->proccessRefund();

    }

    private function initialize(Enrollment $enrollment, PaymentDetail $paymentDetailToRefund, User $user)
    {
        $this->enrollment = $enrollment;
        $this->paymentDetailToRefund = $paymentDetailToRefund;
        $this->user = $user;
    }

    private function checkEnrollmentIsActive()
    {

        if (! $this->enrollment->isActive()) {
            throw new EnrollmentIsNotActive();
        }
    }

    private function checkCourseHasNotStarted()
    {
        $sessionFirst = $this->enrollmentSessionRepository->obtainFirstByEnrollment($this->enrollment);

        if ($sessionFirst) {
            throw new EnrollmentWithSessions();
        }
    }

    private function checkPaymentHasTransactionId()
    {

        $payment = $this->paymentDetailToRefund->payment;

        if (is_null($payment)) {
            throw new PaymentNotExists();
        }

        if (! $payment->hasTransactionId()) {
            throw new TransactionIdIsEmpty();
        }
    }

    private function proccessRefund(): PaymentRefund
    {

        return $this->createRefundCommand->handle($this->paymentDetailToRefund->payment, $this->user);
    }
}
