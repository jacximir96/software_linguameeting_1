<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Salary;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Salary\Action\CreateSalaryAction;
use App\Src\CoachDomain\SalaryDomain\Salary\Request\SalaryRequest;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\SalaryForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateSalaryCoachController extends Controller
{

    public function configView(User $coach)
    {

        $form = app(SalaryForm::class);
        $form->configForCreate($coach);

        view()->share([
            'coach' => $coach,
            'form' => $form,
        ]);

        return view('admin.coach.billing.salary.form');
    }

    public function create(SalaryRequest $request, User $coach)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateSalaryAction::class);
            $action->handle($request, $coach);

            DB::commit();

            flash(trans('coach.billing.salary.create_success'))->success();

            return view('common.feedback_modal');

        } catch (\Throwable $exception) {

            DB::rollBack();

            Log::error('There is an error when create salary.', [
                'request' => $request,
                'coach' => $coach,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.salary.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
