<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Export;

use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\SearchBillingResponse;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BatchPaypalPaymentExport implements FromCollection, WithStyles, WithHeadings
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

        foreach ($this->searchBillingResponse->filterByPaypalAndSorted() as $monthBillingResponse) {

            $coach = $monthBillingResponse->getMonthBilling()->coach();
            $billingInfo = $coach->billingInfo;

            if (is_null($billingInfo)) {
                continue;
            }

            $row = [
                $billingInfo->paypal_email,
                $monthBillingResponse->total()->getAmount(),
                'USD',
                ' ',
                'Paypal Payment to: '.$coach->name.' '.$coach->lastname,
                'Paypal',
                ' ',
                ' ',
                ' ',

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
            'Email/Phone',
            'Amount',
            'Currency code',
            'Reference ID',
            'Note to recipient',
            'Recipient Wallet',
            'Social Feed Privacy',
            'Holler URL',
            'Logo URL',
        ];
    }
}
