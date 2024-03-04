<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Incentive;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Incentive\Action\DeleteIncentiveAction;
use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use Illuminate\Support\Facades\Log;


class DeleteIncentiveController extends Controller
{

    public function __invoke(Incentive $incentive)
    {
        try {

            $action = app(DeleteIncentiveAction::class);
            $action->handle($incentive);

            flash(trans('coach.billing.incentive.delete_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete incentive.', [
                'incentive' => $incentive,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.incentive.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
