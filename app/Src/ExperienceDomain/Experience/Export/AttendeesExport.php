<?php

namespace App\Src\ExperienceDomain\Experience\Export;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendeesExport implements FromView, WithStyles, WithHeadings
{
    private Collection $registeredUsers;

    private Experience $experience;

    public function __construct(Collection $registeredUsers, Experience $experience)
    {
        $this->registeredUsers = $registeredUsers;
        $this->experience = $experience;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->registeredUsers;
    }

    public function view(): View
    {
        return view('admin.experience.attendees_for_excel', [
            'registeredUsers' => $this->registeredUsers,
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
