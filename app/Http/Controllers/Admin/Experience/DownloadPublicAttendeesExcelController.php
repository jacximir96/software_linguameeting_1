<?php
namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Export\PublicAttendeesExport;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use Maatwebsite\Excel\Facades\Excel;


class DownloadPublicAttendeesExcelController extends Controller
{

    public function __invoke(Experience $experience)
    {
        $experienceUsers = $experience->registerPublic;

        return Excel::download(new PublicAttendeesExport($experienceUsers, $experience), 'public_attendees.xlsx');

    }
}
