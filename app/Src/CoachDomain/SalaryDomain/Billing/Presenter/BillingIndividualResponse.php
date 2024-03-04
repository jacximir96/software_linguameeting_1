<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator\MonthBilling;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\Localization\Country\Model\Country;
use Money\Money;

class BillingIndividualResponse implements BillingResponse
{
    use BillingableResponse;

    private MonthBilling $monthBilling;

    private Payment $payment;

    private ?Invoice $invoice;

    public function __construct(MonthBilling $monthBilling, Payment $payment, Invoice $invoice = null)
    {

        $this->monthBilling = $monthBilling;
        $this->payment = $payment;
        $this->invoice = $invoice;
    }

    public function getMonthBilling(): MonthBilling
    {
        return $this->monthBilling;
    }

    public function isPayer(): bool
    {
        return false;
    }

    public function total(): Money
    {
        return $this->monthBilling->total();
    }

    public function hours(): float
    {
        return $this->monthBilling->hours();
    }

    public function salary(): Salary
    {
        return $this->getMonthBilling()->coach()->salary;
    }

    public function country(): Country
    {

        if ($this->monthBilling->coach()->billingInfo->country) {
            return $this->monthBilling->coach()->billingInfo->country;
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
}
