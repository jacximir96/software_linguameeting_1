<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator\MonthBilling;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\Localization\Country\Model\Country;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Illuminate\Support\Collection;
use Money\Money;

class BillingPayerResponse implements BillingResponse
{
    use BillingableResponse;

    //billing del coach
    private MonthBilling $monthBilling;

    //billing del los coach coordinados
    private Collection $coachCoordinatedBillings;

    private Payment $payment;

    private ?Invoice $invoice;

    public function __construct(MonthBilling $monthBilling, Collection $coachCoordinatedBillings, Payment $payment, Invoice $invoice = null)
    {

        $this->monthBilling = $monthBilling;
        $this->coachCoordinatedBillings = $coachCoordinatedBillings;
        $this->payment = $payment;
        $this->invoice = $invoice;
    }

    public function getMonthBilling(): MonthBilling
    {
        return $this->monthBilling;
    }

    public function getCoachCoordinatedBillings(): Collection
    {
        return $this->coachCoordinatedBillings;
    }

    public function isPayer(): bool
    {
        return true;
    }

    public function total(): Money //alias
    {return $this->totalSalary();
    }

    public function hours(): float
    {
        return $this->getMonthBilling()->hours() + $this->totalHoursCoaches();
    }

    public function salary(): Salary
    {
        return $this->monthBilling->coach()->salary;
    }

    public function country(): Country
    {

        $country = $this->monthBilling->coach()->billingInfo->country;

        if ($country) {
            return $country;
        }

        return $this->monthBilling->coach()->country;
    }

    public function payment(): Payment
    {
        return $this->payment;
    }

    public function hasInvoice(): bool
    {
        return ! is_null($this->invoice);
    }

    public function invoice(): Invoice
    {
        return $this->invoice;
    }

    public function hasSalary(): bool
    {
        return ! is_null($this->getMonthBilling()->coach()->salary);
    }

    public function totalSalary(): Money
    {

        $salary = $this->monthBilling->monthSalary()->total();

        foreach ($this->coachCoordinatedBillings as $billing) {
            $salary = $salary->add($billing->monthSalary()->total());
        }

        return $salary;
    }

    public function totalHoursCoaches(): float
    {

        $hours = 0;

        foreach ($this->coachCoordinatedBillings as $billing) {
            $hours += $billing->hours();
        }

        return $hours;
    }

    public function totalSalaryCoaches(): Money
    {

        $linguaMoney = new LinguaMoney();

        $salary = $linguaMoney->buildZero($this->monthBilling->coach()->currency()->code);

        foreach ($this->coachCoordinatedBillings as $billing) {
            $salary = $salary->add($billing->monthSalary()->total());
        }

        return $salary;
    }

    public function coachesIds(): array
    {

        $coachesIds = [];
        $coachesIds[$this->monthBilling->coach()->id] = $this->monthBilling->coach()->id;

        foreach ($this->coachCoordinatedBillings as $monthBilling) {
            $coachesIds[$monthBilling->coach()->id] = $monthBilling->coach()->id;
        }

        return $coachesIds;
    }
}
