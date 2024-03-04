<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Action;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\CoachHasNotPaymentInfo;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Exception\InvoiceAlreadyExistsForTheMonth;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Action\Command\CreateInvoiceDetailCommand;
use App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Model\InvoiceDetail;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\BillingResponse;
use App\Src\Config\Model\Config;
use App\Src\Shared\Model\ValueObject\InvoiceDetailQuantity;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class GenerateInvoiceAction
{
    private InvoiceRepository $invoiceRepository;

    private CreateInvoiceDetailCommand $createInvoiceDetailCommand;

    public function __construct(InvoiceRepository $invoiceRepository, CreateInvoiceDetailCommand $createInvoiceDetailCommand)
    {

        $this->invoiceRepository = $invoiceRepository;
        $this->createInvoiceDetailCommand = $createInvoiceDetailCommand;
    }

    public function handle(BillingResponse $billingResponse): Invoice
    {

        $this->checkCoachCanCreateInvoice($billingResponse->getMonthBilling()->coach());

        $this->checkInvoiceAlreadyExists($billingResponse);

        $invoice = $this->createInvoice($billingResponse->getMonthBilling()->coach(), $billingResponse->getMonthBilling()->month());

        $this->createInvoiceDetail($invoice, $billingResponse);

        return $invoice;
    }

    private function checkCoachCanCreateInvoice(User $coach)
    {

        if (! $coach->billingInfo->hasPaymentInfo()) {
            throw new CoachHasNotPaymentInfo();
        }
    }

    private function checkInvoiceAlreadyExists(BillingResponse $billingResponse)
    {

        $invoice = $this->invoiceRepository->obtainByCoachAndMonth($billingResponse->getMonthBilling()->coach(), $billingResponse->getMonthBilling()->month());

        if ($invoice) {
            throw new InvoiceAlreadyExistsForTheMonth();
        }
    }

    private function createInvoice(User $coach, Month $month): Invoice
    {

        $number = $this->obtainLastNumber($coach);
        $config = Config::first();

        $invoice = new Invoice();
        $invoice->coach_id = $coach->id;
        $invoice->number = $number;
        $invoice->date = Carbon::now();
        $invoice->month = $month->month();
        $invoice->year = $month->year();
        $invoice->currency = $coach->billingInfo->currency->code;
        $invoice->info_to = $config->paid_info;
        $invoice->info_from = $coach->billingInfo->paid_info;

        $invoice->save();

        return $invoice;
    }

    private function obtainLastNumber(User $coach)
    {

        $last = $this->invoiceRepository->obtainLastFromCoach($coach);

        $number = 1;
        if ($last) {
            $number = $last->number + 1;
        }

        return $number;
    }

    private function createInvoiceDetail(Invoice $invoice, BillingResponse $billingResponse)
    {

        $this->addCoachingHours($invoice, $billingResponse);

        if ($billingResponse->getMonthBilling()->isPayerBilling()) {
            $this->addCoachesSalary($invoice, $billingResponse);
        }

        if ($billingResponse->getMonthBilling()->hasIncentives()) {
            $this->addIncentive($invoice, $billingResponse);
        }

        if ($billingResponse->getMonthBilling()->hasDiscounts()) {
            $this->addDiscount($invoice, $billingResponse);
        }

        if ($billingResponse->getMonthBilling()->hasExtraSalary()) {
            $this->addExtraSalary($invoice, $billingResponse);
        }
    }

    private function addCoachingHours(Invoice $invoice, BillingResponse $billingResponse): InvoiceDetail
    {

        $month = writeMonth($billingResponse->getMonthBilling()->month());
        $year = $billingResponse->getMonthBilling()->month()->year();
        $description = sprintf(config('linguameeting.billing.coach.invoice.detail_description.coaching_hours'), $month, $year);
        $value = $billingResponse->getMonthBilling()->monthSalary()->baseSalary()->getSalary();
        $quantity = new InvoiceDetailQuantity(1);

        return $this->createInvoiceDetailCommand->handle($invoice, $quantity, $value, $description);
    }

    private function addCoachesSalary(Invoice $invoice, BillingResponse $billingResponse): InvoiceDetail
    {

        $description = config('linguameeting.billing.coach.invoice.detail_description.from_coaches');
        $value = $billingResponse->totalSalaryCoaches();
        $quantity = new InvoiceDetailQuantity(1);

        return $this->createInvoiceDetailCommand->handle($invoice, $quantity, $value, $description, true);
    }

    private function addIncentive(Invoice $invoice, BillingResponse $billingResponse): InvoiceDetail
    {

        $description = config('linguameeting.billing.coach.invoice.detail_description.incentives');
        $value = $billingResponse->getMonthBilling()->monthSalary()->baseIncentive()->total();
        $quantity = new InvoiceDetailQuantity(1);

        return $this->createInvoiceDetailCommand->handle($invoice, $quantity, $value, $description);
    }

    private function addDiscount(Invoice $invoice, BillingResponse $billingResponse): InvoiceDetail
    {

        $description = config('linguameeting.billing.coach.invoice.detail_description.discounts');
        $value = $billingResponse->getMonthBilling()->monthSalary()->baseDiscount()->getDiscount()->negative();
        $quantity = new InvoiceDetailQuantity(1);

        return $this->createInvoiceDetailCommand->handle($invoice, $quantity, $value, $description);
    }

    private function addExtraSalary(Invoice $invoice, BillingResponse $billingResponse): InvoiceDetail
    {

        $description = config('linguameeting.billing.coach.invoice.detail_description.extra_salary');
        $value = $billingResponse->getMonthBilling()->monthSalary()->extraSalary()->getExtraSalary();
        $quantity = new InvoiceDetailQuantity(1);

        return $this->createInvoiceDetailCommand->handle($invoice, $quantity, $value, $description);
    }
}
