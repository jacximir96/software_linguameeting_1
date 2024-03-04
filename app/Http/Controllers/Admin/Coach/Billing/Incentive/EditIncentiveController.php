<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Incentive;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Incentive\Action\UpdateIncentiveAction;
use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\Incentive\Request\IncentiveRequest;
use App\Src\CoachDomain\SalaryDomain\Incentive\Service\IncentiveForm;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Action\UpdateIncentiveTypeAction;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Service\IncentiveTypeForm;
use Illuminate\Support\Facades\Log;


class EditIncentiveController extends Controller
{

    public function configView(Incentive $incentive)
    {

        $form = app(IncentiveForm::class);
        $form->configForEdit($incentive);

        view()->share([
            'incentive' => $incentive,
            'form' => $form,
        ]);

        return view('admin.coach.billing.incentive.form');
    }

    public function update(IncentiveRequest $request, Incentive $incentive)
    {
        try {

            $action = app(UpdateIncentiveAction::class);
            $action->handle($request, $incentive);

            flash(trans('coach.billing.incentive.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update incentive.', [
                'incentive' => $incentive,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.incentive.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
