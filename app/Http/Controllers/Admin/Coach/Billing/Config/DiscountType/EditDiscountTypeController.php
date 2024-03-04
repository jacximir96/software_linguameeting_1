<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Action\UpdateDiscountTypeAction;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Request\DiscountTypeRequest;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Service\DiscountTypeForm;
use Illuminate\Support\Facades\Log;


class EditDiscountTypeController extends Controller
{

    public function configView(DiscountType $discountType)
    {

        $form = app(DiscountTypeForm::class);
        $form->configForEdit($discountType);

        view()->share([
            'discountType' => $discountType,
            'form' => $form,
        ]);

        return view('admin.coach.billing.config.discount-type.form');
    }

    public function update(DiscountTypeRequest $request, DiscountType $discountType)
    {
        try {

            $action = app(UpdateDiscountTypeAction::class);
            $action->handle($request, $discountType);

            flash(trans('coach.billing.config.discount_type.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update discount type.', [
                'discountType' => $discountType,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.discount_type.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
