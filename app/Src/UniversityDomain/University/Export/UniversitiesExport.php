<?php

namespace App\Src\UniversityDomain\University\Export;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UniversitiesExport implements FromView, WithStyles, WithHeadings
{
    private Collection $universities;

    public function __construct(Collection $universities)
    {

        $this->universities = $universities;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->universities;
    }

    public function view(): View
    {
        return view('admin.university.list_for_excel', [
            'universities' => $this->universities,
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
