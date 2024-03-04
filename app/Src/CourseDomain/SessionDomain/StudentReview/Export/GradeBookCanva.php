<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Export;

use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\StudentsTableResponse;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradeBookCanva implements FromView, WithStyles, WithHeadings, WithColumnWidths
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
        return view('instructor.course.gradebook.download_canva_format', [
            'instructor' => $this->instructor,
            'maxSessions' => $this->maxSessions,
            'students' => $this->studentsTableResponse,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Obtener la cantidad total de columnas en la hoja de cálculo
        $totalColumns = $sheet->getHighestColumn();

        // Aplicar estilos a todas las columnas excepto la primera
        for ($column = 'B'; $column <= $totalColumns; $column++) {
            $sheet->getStyle($column)->getAlignment()->setHorizontal('right');
        }

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '000000'], // Fondo negro
                ],
            ],
        ];
    }

    public function headings(): array
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, 'B' => 5, 'C' => 5, 'D' => 5, 'E' => 5, 'F' => 5, 'G' => 5, 'H' => 5, 'I' => 5,
            'J' => 30, 'K' => 5, 'L' => 5, 'M' => 5, 'N' => 5, 'O' => 5, 'P' => 5, 'Q' => 5, 'R' => 5,
        ];
    }
}
