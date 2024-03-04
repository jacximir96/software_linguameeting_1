<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator\MonthBilling;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\Localization\Country\Model\Country;
use Money\Money;

interface BillingResponse
{
    public function getMonthBilling(): MonthBilling;

    public function isPayer(): bool;

    public function total(): Money;

    public function hours(): float;

    public function hasSalary(): bool;

    public function salary(): Salary;

    public function country(): Country;

    public function payment(): Payment;

    public function hasInvoice(): bool;

    public function invoice(): Invoice;
}
