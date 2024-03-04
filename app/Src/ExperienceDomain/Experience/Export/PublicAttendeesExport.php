<?php

namespace App\Src\ExperienceDomain\Experience\Export;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PublicAttendeesExport implements FromView, WithStyles, WithHeadings
{
    private Collection $experienceUsers;

    private Experience $experience;

    public function __construct(Collection $experienceUsers, Experience $experience)
    {
        $this->experienceUsers = $experienceUsers;
        $this->experience = $experience;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->experienceUsers;
    }

    public function view(): View
    {
        return view('admin.experience.public_attendees_for_excel', [
            'experienceUsers' => $this->experienceUsers,
            'experience' => $this->experience,
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
