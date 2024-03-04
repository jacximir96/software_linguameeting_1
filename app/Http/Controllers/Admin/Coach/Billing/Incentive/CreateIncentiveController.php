<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Incentive;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Incentive\Action\CreateIncentiveAction;
use App\Src\CoachDomain\SalaryDomain\Incentive\Request\IncentiveRequest;
use App\Src\CoachDomain\SalaryDomain\Incentive\Service\IncentiveForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class CreateIncentiveController extends Controller
{

    public function configView(User $coach)
    {

        $form = app(IncentiveForm::class);
        $form->configForCreate($coach);

        view()->share([
            'coach' => $coach,
            'form' => $form,
        ]);

        return view('admin.coach.billing.incentive.form');
    }

    public function create(IncentiveRequest $request, User $coach)
    {
        try {

            $action = app(CreateIncentiveAction::class);
            $incentive = $action->handle($request, $coach);

            flash(trans('coach.billing.incentive.create_success'))->success();

            return redirect()->route('get.admin.coach.billing.incentive.edit', $incentive->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when creating incentive for coach.', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.incentive.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
