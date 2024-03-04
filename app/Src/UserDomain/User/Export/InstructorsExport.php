<?php

namespace App\Src\UserDomain\User\Export;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstructorsExport implements FromView, WithStyles, WithHeadings
{
    private Collection $instructors;

    public function __construct(Collection $instructors)
    {

        $this->instructors = $instructors;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->instructors;
    }

    public function view(): View
    {
        return view('admin.instructor.list_for_excel', [
            'instructors' => $this->instructors,
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
