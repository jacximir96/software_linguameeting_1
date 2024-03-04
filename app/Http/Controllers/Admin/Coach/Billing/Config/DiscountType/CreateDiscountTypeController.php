<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Action\CreateDiscountTypeAction;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Request\DiscountTypeRequest;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Service\DiscountTypeForm;
use Illuminate\Support\Facades\Log;


class CreateDiscountTypeController extends Controller
{

    public function configView()
    {

        $form = app(DiscountTypeForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.coach.billing.config.discount-type.form');
    }

    public function create(DiscountTypeRequest $request)
    {
        try {

            $action = app(CreateDiscountTypeAction::class);
            $type = $action->handle($request);

            flash(trans('coach.billing.config.discount_type.create_success'))->success();

            return redirect()->route('get.admin.coach.billing.config.discount.options.edit', $type->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when creating discount type.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.discount_type.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
