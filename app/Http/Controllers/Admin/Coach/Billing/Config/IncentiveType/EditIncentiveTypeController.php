<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Action\UpdateIncentiveTypeAction;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Service\IncentiveTypeForm;
use Illuminate\Support\Facades\Log;


class EditIncentiveTypeController extends Controller
{

    public function configView(IncentiveType $incentiveType)
    {

        $form = app(IncentiveTypeForm::class);
        $form->configForEdit($incentiveType);

        view()->share([
            'incentiveType' => $incentiveType,
            'form' => $form,
        ]);

        return view('admin.coach.billing.config.incentive-type.form');
    }

    public function update(IncentiveTypeRequest $request, IncentiveType $incentiveType)
    {
        try {

            $action = app(UpdateIncentiveTypeAction::class);
            $action->handle($request, $incentiveType);

            flash(trans('coach.billing.config.incentive_type.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update incentive type.', [
                'incentiveType' => $incentiveType,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.incentive_type.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
