<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Salary;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Salary\Action\EditSalaryAction;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\CoachDomain\SalaryDomain\Salary\Request\SalaryRequest;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\SalaryForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditSalaryCoachController extends Controller
{

    public function configView(Salary $salary)
    {

        $form = app(SalaryForm::class);
        $form->configForEdit($salary);

        view()->share([
            'salary' => $salary,
            'form' => $form,
        ]);

        return view('admin.coach.billing.salary.form');
    }

    public function update(SalaryRequest $request, Salary $salary)
    {
        try {

            DB::beginTransaction();

            $action = app(EditSalaryAction::class);
            $action->handle($request, $salary);

            DB::commit();

            flash(trans('coach.billing.salary.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            DB::rollBack();

            Log::error('There is an error when update salary.', [
                'salary' => $salary,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.salary.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
