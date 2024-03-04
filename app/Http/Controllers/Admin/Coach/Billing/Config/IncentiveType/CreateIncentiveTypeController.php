<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Action\CreateIncentiveTypeAction;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Service\IncentiveTypeForm;
use Illuminate\Support\Facades\Log;


class CreateIncentiveTypeController extends Controller
{

    public function configView()
    {

        $form = app(IncentiveTypeForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.coach.billing.config.incentive-type.form');
    }

    public function create(IncentiveTypeRequest $request)
    {
        try {

            $action = app(CreateIncentiveTypeAction::class);
            $type = $action->handle($request);

            flash(trans('coach.billing.config.incentive_type.create_success'))->success();

            return redirect()->route('get.admin.coach.billing.config.incentive.options.edit', $type->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when creating incentive type.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.incentive_type.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
