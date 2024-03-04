<?php
namespace App\Http\Controllers\Admin\Instructor\Help;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorHelp\Repository\InstructorHelpRepository;
use App\Src\InstructorDomain\InstructorHelp\Presenter\Breadcrumb\IndexBreadcrumb;



class IndexController extends Controller
{
    use Breadcrumable;

    private InstructorHelpRepository $instructorHelpRepository;

    public function __construct (InstructorHelpRepository $instructorHelpRepository){

        $this->instructorHelpRepository = $instructorHelpRepository;
    }


    public function __invoke()
    {

        $helps = $this->instructorHelpRepository->all();

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'helps' => $helps,
        ]);

        return view('admin.instructor.help.index');
    }
}
