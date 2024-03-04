<?php
namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Export\AttendeesExport;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use Maatwebsite\Excel\Facades\Excel;


class DownloadAttendeesExcelController extends Controller
{

    public function __invoke(Experience $experience)
    {
        $registeredUsers = $experience->register;

        return Excel::download(new AttendeesExport($registeredUsers, $experience), 'attendees.xlsx');
    }
}
