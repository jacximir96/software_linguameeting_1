<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Action\DeleteDiscountTypeAction;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use Illuminate\Support\Facades\Log;


class DeleteDiscountTypeController extends Controller
{

    public function __invoke(DiscountType $discountType)
    {
        try {

            $action = app(DeleteDiscountTypeAction::class);
            $action->handle($discountType);

            flash(trans('coach.billing.config.discount_type.delete_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete discount type.', [
                'discountType' => $discountType,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.discount_type.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
