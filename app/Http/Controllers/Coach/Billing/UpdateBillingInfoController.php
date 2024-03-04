<?php
namespace App\Http\Controllers\Coach\Billing;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\BillingInfo\Action\CreateBillingInfoAction;
use App\Src\CoachDomain\BillingInfo\Action\UpdateBillingInfoAction;
use App\Src\CoachDomain\BillingInfo\Presenter\Breadcrumb\BillingProfileInfoBreadcrumb;
use App\Src\CoachDomain\BillingInfo\Request\BillingProfileInfoRequest;
use App\Src\CoachDomain\BillingInfo\Service\EditBillingInfoForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UpdateBillingInfoController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $coach = user();

        $form = app(EditBillingInfoForm::class);
        $form->config(user());

        $breadcrumb = new BillingProfileInfoBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'form' => $form,
        ]);

        return view('coach.billing.profile.form');
    }

    public function update(BillingProfileInfoRequest $request)
    {
        try {

            DB::beginTransaction();

            $coach = user();

            if ($coach->billingInfo){
                $action = app(UpdateBillingInfoAction::class);
                $action->handle($request, user());
            }
            else{
                $action = app(CreateBillingInfoAction::class);
                $action->handle($request, user());
            }

            DB::commit();

            flash(trans('coach.billing.info.success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update coach billing info.', [
                'coach' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.info.error.on_update'))->error();

            return back();
        }
    }
}
