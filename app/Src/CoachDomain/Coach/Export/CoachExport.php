<?php

namespace App\Src\CoachDomain\Coach\Export;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CoachExport implements FromView, WithStyles, WithHeadings
{
    private Collection $coaches;

    public function __construct(Collection $coaches)
    {

        $this->coaches = $coaches;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->coaches;
    }

    public function view(): View
    {
        return view('admin.coach.list_for_excel', [
            'coaches' => $this->coaches,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            ['First row', 'First row'],
            ['Second row', 'Second row'],
        ];
    }
}
