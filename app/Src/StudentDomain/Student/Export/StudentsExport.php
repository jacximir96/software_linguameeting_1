<?php

namespace App\Src\StudentDomain\Student\Export;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromView, WithStyles, WithHeadings
{
    private Collection $students;

    public function __construct(Collection $students)
    {

        $this->students = $students;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->students;
    }

    public function view(): View
    {
        return view('admin.student.list_for_excel', [
            'students' => $this->students,
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
