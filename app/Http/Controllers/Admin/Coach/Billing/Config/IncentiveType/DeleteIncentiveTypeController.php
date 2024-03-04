<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Action\DeleteIncentiveTypeAction;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use Illuminate\Support\Facades\Log;


class DeleteIncentiveTypeController extends Controller
{

    public function __invoke(IncentiveType $incentiveType)
    {
        try {

            $action = app(DeleteIncentiveTypeAction::class);
            $action->handle($incentiveType);

            flash(trans('coach.billing.config.incentive_type.delete_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete incentive type.', [
                'incentiveType' => $incentiveType,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.incentive_type.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
