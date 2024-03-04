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
use Illuminate\Support\Collection;
use Money\Money;

class BillingPayerPresenter
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

    public function handle(Month $month, User $coach): BillingPayerResponse
    {

        $coachBilling = $this->obtainMonthBillingCoach($month, $coach);

        $coachCoordinatedBillings = $this->obtainCoachCoordinatedBillings($month, $coach);

        $total = $this->totalSalary($coachBilling, $coachCoordinatedBillings);

        $payment = $this->obtainPayment($coachBilling, $total);

        $invoice = $this->obtainInvoice($month, $coach);

        return new BillingPayerResponse($coachBilling, $coachCoordinatedBillings, $payment, $invoice);
    }

    private function obtainMonthBillingCoach(Month $month, User $coach): MonthBilling
    {

        return $this->billingCalculator->obtainForMonthAndCoach($month, $coach);
    }

    private function obtainCoachCoordinatedBillings(Month $month, User $coach): Collection
    {

        $billings = collect();

        foreach ($coach->coachCoordinator as $coachCoordinator) {

            $coordinated = $coachCoordinator->coach;
            $billing = $this->billingCalculator->obtainForMonthAndCoach($month, $coordinated, false);

            $billings->push($billing);
        }

        return $billings;

    }

    private function totalSalary(MonthBilling $monthBilling, Collection $coachCoordinatedBilling): Money
    {

        $salary = $monthBilling->total();

        foreach ($coachCoordinatedBilling as $billing) {
            $salary = $salary->add($billing->monthSalary()->total());
        }

        return $salary;
    }

    //dupe en BillingPayerResponse
    private function obtainPayment(MonthBilling $monthBilling, Money $total)
    {

        $payment = $this->paymentRepository->findByMonthAndCoach($monthBilling->month(), $monthBilling->coach());

        if ($payment) {
            return $payment;
        }

        return $this->createPaymentCommand->handle($monthBilling->month(), $monthBilling->coach(), $total);
    }

    private function obtainInvoice(Month $month, User $coach): ?Invoice
    {

        return $this->invoiceRepository->obtainByCoachAndMonth($coach, $month);

    }
}
