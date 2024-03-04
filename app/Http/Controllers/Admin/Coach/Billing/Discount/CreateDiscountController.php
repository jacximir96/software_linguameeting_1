<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Discount;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Discount\Action\CreateDiscountAction;
use App\Src\CoachDomain\SalaryDomain\Discount\Request\DiscountRequest;
use App\Src\CoachDomain\SalaryDomain\Discount\Service\DiscountForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class CreateDiscountController extends Controller
{

    public function configView(User $coach)
    {

        $form = app(DiscountForm::class);
        $form->configForCreate($coach);

        view()->share([
            'coach' => $coach,
            'form' => $form,
        ]);

        return view('admin.coach.billing.discount.form');
    }

    public function create(DiscountRequest $request, User $coach)
    {
        try {

            $action = app(CreateDiscountAction::class);
            $discount = $action->handle($request, $coach);

            flash(trans('coach.billing.discount.create_success'))->success();

            return redirect()->route('get.admin.coach.billing.discount.edit', $discount->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when creating discount for coach.', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.discount.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
