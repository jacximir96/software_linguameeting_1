<?php
namespace App\Http\Controllers\Admin\Student\Help;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\StudentDomain\StudentHelp\Repository\StudentHelpRepository;
use App\Src\StudentDomain\StudentHelp\Presenter\Breadcrumb\IndexBreadcrumb;



class IndexController extends Controller
{
    use Breadcrumable;

    private StudentHelpRepository $studentHelpRepository;

    public function __construct (StudentHelpRepository $studentHelpRepository){

        $this->studentHelpRepository = $studentHelpRepository;
    }


    public function __invoke()
    {

        $helps = $this->studentHelpRepository->all();

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'helps' => $helps,
        ]);

        return view('admin.student.help.index');
    }
}
