<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Export;

use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\StudentsTableResponse;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradeBookExcel implements FromView, WithStyles, WithHeadings, WithColumnWidths
{

    private User $instructor;
    private int $maxSessions;
    private Collection $studentsTableResponse;


    public function __construct(User $instructor, int $maxSessions, Collection $studentsTableResponse)
    {
        $this->instructor = $instructor;
        $this->maxSessions = $maxSessions;
        $this->studentsTableResponse = $studentsTableResponse;
    }

    public function view(): View
    {
        return view('instructor.course.gradebook.download_excel_format', [
            'instructor' => $this->instructor,
            'maxSessions' => $this->maxSessions,
            'students' => $this->studentsTableResponse,
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

    public function columnWidths(): array
    {
        return [];
    }
}
