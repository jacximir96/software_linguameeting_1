<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Discount;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Discount\Action\UpdateDiscountAction;
use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\Discount\Request\DiscountRequest;
use App\Src\CoachDomain\SalaryDomain\Discount\Service\DiscountForm;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Action\UpdateDiscountTypeAction;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Request\DiscountTypeRequest;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Service\DiscountTypeForm;
use Illuminate\Support\Facades\Log;


class EditDiscountController extends Controller
{

    public function configView(Discount $discount)
    {

        $form = app(DiscountForm::class);
        $form->configForEdit($discount);

        view()->share([
            'discount' => $discount,
            'form' => $form,
        ]);

        return view('admin.coach.billing.discount.form');
    }

    public function update(DiscountRequest $request, Discount $discount)
    {
        try {

            $action = app(UpdateDiscountAction::class);
            $action->handle($request, $discount);

            flash(trans('coach.billing.discount.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update discount.', [
                'discount' => $discount,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.discount.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
