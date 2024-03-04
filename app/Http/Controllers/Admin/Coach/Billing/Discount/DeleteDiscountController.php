<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Discount;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Discount\Action\DeleteDiscountAction;
use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use Illuminate\Support\Facades\Log;


class DeleteDiscountController extends Controller
{

    public function __invoke(Discount $discount)
    {
        try {

            $action = app(DeleteDiscountAction::class);
            $action->handle($discount);

            flash(trans('coach.billing.discount.delete_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete discount.', [
                'discount' => $discount,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.discount.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
