<?php

namespace App\Src\CourseDomain\Course\Export;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CoursesExport implements FromView, WithStyles, WithHeadings
{
    private Collection $courses;

    public function __construct(Collection $courses)
    {

        $this->courses = $courses;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->courses;
    }

    public function view(): View
    {
        return view('admin.course.list_for_excel', [
            'courses' => $this->courses,
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
