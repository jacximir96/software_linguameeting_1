<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\CoachDomain\Payment\Action\Command\CreatePaymentCommand;
use App\Src\CoachDomain\Payment\Repository\PaymentRepository;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator\BillingCalculator;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator\MonthBilling;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class BillingIndividualPresenter
{
    private BillingCalculator $billingCalculator;

    private PaymentRepository $paymentRepository;

    private InvoiceRepository $invoiceRepository;

    private CreatePaymentCommand $createPaymentCommand;

    public function __construct(BillingCalculator $billingCalculator,
        PaymentRepository $paymentRepository,
        InvoiceRepository $invoiceRepository,
        CreatePaymentCommand $createPaymentCommand)
    {
        $this->billingCalculator = $billingCalculator;
        $this->paymentRepository = $paymentRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->createPaymentCommand = $createPaymentCommand;
    }

    public function handle(Month $month, User $coach): BillingIndividualResponse
    {

        $isRealPaid = $this->isRealPaid($coach);

        $monthBilling = $this->billingCalculator->obtainForMonthAndCoach($month, $coach, $isRealPaid);

        $payment = $this->obtainPayment($monthBilling);

        $invoice = $this->obtainInvoice($coach, $month);

        return new BillingIndividualResponse($monthBilling, $payment, $invoice);
    }

    private function isRealPaid(User $coach): bool
    {
        $isRealPaid = true;

        $isCoachCoordinated = $coach->coachCoordinated;
        if ($isCoachCoordinated) {
            $isRealPaid = false;
        }

        return $isRealPaid;
    }

    private function obtainPayment(MonthBilling $monthBilling)
    {

        $payment = $this->paymentRepository->findByMonthAndCoach($monthBilling->month(), $monthBilling->coach());

        if ($payment) {
            return $payment;
        }

        return $this->createPaymentCommand->handle($monthBilling->month(), $monthBilling->coach(), $monthBilling->total());
    }

    private function obtainInvoice(User $coach, Month $month): ?Invoice
    {

        return $this->invoiceRepository->obtainByCoachAndMonth($coach, $month);

    }
}
