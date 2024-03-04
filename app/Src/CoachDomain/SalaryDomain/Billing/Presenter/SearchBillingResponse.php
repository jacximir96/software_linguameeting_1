<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

use App\Src\TimeDomain\Month\Service\Month;
use Illuminate\Support\Collection;

class SearchBillingResponse
{
    private Month $month;

    private Collection $payerBilling;

    private Collection $individualBilling;

    public function __construct(Month $month, Collection $payerBilling, Collection $individualBilling)
    {
        $this->month = $month;
        $this->payerBilling = $payerBilling;
        $this->individualBilling = $individualBilling;
    }

    public function getMonth(): Month
    {
        return $this->month;
    }

    public function getPayerBilling(): Collection
    {
        return $this->payerBilling;
    }

    public function getIndividualBilling(): Collection
    {
        return $this->individualBilling;
    }

    public function billingSorted(): Collection
    {

        $sorted = collect();

        foreach ($this->payerBilling as $payerBilling) {
            $sorted->push($payerBilling);
        }

        foreach ($this->individualBilling as $payerBilling) {
            $sorted->push($payerBilling);
        }

        return $sorted->sortBy(function ($billingResponse) {
            return $billingResponse->getMonthBilling()->coach()->writeFullName();
        });

    }

    public function filterByTransferAndSorted(): Collection
    {

        $filtered = collect();

        foreach ($this->payerBilling as $payerBilling) {
            if ($payerBilling->isTransferPaid()) {
                $filtered->push($payerBilling);
            }
        }

        foreach ($this->individualBilling as $payerBilling) {
            if ($payerBilling->isTransferPaid()) {
                $filtered->push($payerBilling);
            }
        }

        return $filtered->sortBy(function ($billingResponse) {
            return $billingResponse->getMonthBilling()->coach()->writeFullName();
        });
    }

    public function filterByPaypalAndSorted(): Collection
    {

        $filtered = collect();

        foreach ($this->payerBilling as $payerBilling) {
            if ($payerBilling->isTransferPaid()) {
                $filtered->push($payerBilling);
            }
        }

        foreach ($this->individualBilling as $payerBilling) {
            if ($payerBilling->isTransferPaid()) {
                $filtered->push($payerBilling);
            }
        }

        return $filtered->sortBy(function ($billingResponse) {
            return $billingResponse->getMonthBilling()->coach()->writeFullName();
        });
    }
}
