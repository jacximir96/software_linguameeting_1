<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Export;

use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\SearchBillingResponse;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BatchPaymentExport implements FromCollection, WithStyles, WithHeadings
{
    private SearchBillingResponse $searchBillingResponse;

    private LinguaMoney $linguaMoney;

    public function __construct(SearchBillingResponse $searchBillingResponse, LinguaMoney $linguaMoney)
    {

        $this->searchBillingResponse = $searchBillingResponse;
        $this->linguaMoney = $linguaMoney;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $rows = collect();
        foreach ($this->searchBillingResponse->filterByTransferAndSorted() as $monthBillingResponse) {

            $coach = $monthBillingResponse->getMonthBilling()->coach();
            $billingInfo = $coach->billingInfo;

            if (is_null($billingInfo)) {
                continue;
            }

            $row = [
                $coach->name.' '.$coach->lastname,
                $coach->email,
                '',
                'PERSON',
                'source',
                $monthBillingResponse->total()->getAmount(),
                'USD',
                $billingInfo->currency->code,
                $billingInfo->swift,
                $billingInfo->bank_account,
                $monthBillingResponse->country()->iso2,
                $billingInfo->city,
                $billingInfo->address,
                $billingInfo->postal_code,
            ];

            $rows->push($row);
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'name',
            'recipientEmail',
            'paymentReference',
            'receiverType',
            'amountCurrency',
            'amount',
            'sourceCurrency',
            'targetCurrency',
            'BIC',
            'accountNumber',
            'addressCountryCode',
            'addressCity',
            'addressFirstLine',
            'addressPostCode',
        ];
    }
}
