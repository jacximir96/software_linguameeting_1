<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Salary;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb\IndexSalaryCoordinatorBreadcrumb;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForAllForm;
use App\Src\CoachDomain\SalaryDomain\Billing\Service\SearchBillingForOneForm;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

//Index and config salary coordinators by semesters
class IndexCoordinatorController extends Controller
{
    use Breadcrumable;

    //construct
    private CoachRepository $coachRepository;

    private FieldFormBuilder $fieldFormBuilder;


    public function __construct (CoachRepository $coachRepository, FieldFormBuilder $fieldFormBuilder){

        $this->coachRepository = $coachRepository;
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function __invoke()
    {

        $coaches = $this->coachRepository->obtainToConfigSemesterFinished();

        $coordinatorsOptions = $this->fieldFormBuilder->obtainCoachesCoordinatorsOptions();

        $breadcrumb = new IndexSalaryCoordinatorBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coaches' => $coaches,
            'coordinatorsOptions' => $coordinatorsOptions,
        ]);

        return view('admin.coach.billing.salary.coordinator_index');
    }
}
