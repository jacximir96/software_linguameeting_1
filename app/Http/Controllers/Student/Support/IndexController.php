<?php
namespace App\Http\Controllers\Student\Support;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\HelpDomain\Issue\Service\IssueForm;
use App\Src\StudentDomain\StudentHelp\Repository\StudentHelpRepository;
use App\Src\StudentDomain\StudentHelp\Presenter\Breadcrumb\Student\IndexBreadcrumb;


class IndexController extends Controller
{
    use Breadcrumable;

    private StudentHelpRepository $coachHelpRepository;

    public function __construct (StudentHelpRepository $coachHelpRepository){

        $this->coachHelpRepository = $coachHelpRepository;
    }


    public function __invoke()
    {

        $helps = $this->coachHelpRepository->all();

        $form = app(IssueForm::class);
        $form->config(user());

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'form' => $form,
            'helps' => $helps,
        ]);

        return view('student.help.index');
    }
}
