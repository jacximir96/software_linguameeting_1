<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Export;

use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\SearchBillingResponse;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BillingExport implements FromView, WithStyles, WithHeadings
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
        return $this->searchBillingResponse->billingSorted();
    }

    public function view(): View
    {
        return view('admin.coach.billing.for-all.file.billing_excel', [
            'sortedBilling' => $this->searchBillingResponse->billingSorted(),
            'linguaMoney' => $this->linguaMoney,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function headings(): array
    {
        return [];
    }
}
