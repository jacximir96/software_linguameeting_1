<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\TimeDomain\Month\Service\Month;
use Illuminate\Support\Collection;

class SearchBillingPresenter
{
    private CoachRepository $coachRepository;

    private BillingPayerPresenter $billingPayerPresenter;

    private BillingIndividualPresenter $billingIndividualPresenter;

    private $coachesIds = [];

    public function __construct(CoachRepository $coachRepository, BillingPayerPresenter $billingPayerPresenter, BillingIndividualPresenter $billingIndividualPresenter)
    {
        $this->coachRepository = $coachRepository;
        $this->billingPayerPresenter = $billingPayerPresenter;
        $this->billingIndividualPresenter = $billingIndividualPresenter;
    }

    public function handle(Month $month): SearchBillingResponse
    {

        $this->coachesIds = [];

        $payersBilling = $this->obtainPayerBilling($month);

        $indivdualBilling = $this->obatainIndividualBilling($month);

        return new SearchBillingResponse($month, $payersBilling, $indivdualBilling);
    }

    private function obtainPayerBilling(Month $month): Collection
    {

        $payerBilling = collect();
        $payers = $this->coachRepository->obtainPayersForBilling();

        foreach ($payers as $payer) {
            $monthBilling = $this->billingPayerPresenter->handle($month, $payer);
            $payerBilling->push($monthBilling);
            $this->coachesIds = $monthBilling->coachesIds();
        }

        return $payerBilling;
    }

    private function obatainIndividualBilling(Month $month): Collection
    {

        $individualBilling = collect();

        $coaches = $this->coachRepository->obtainForBillingNotIncludeInIds($this->coachesIds);

        foreach ($coaches as $coach) {
            $monthBilling = $this->billingIndividualPresenter->handle($month, $coach);
            $individualBilling->push($monthBilling);
        }

        return $individualBilling;
    }
}
