<?php

namespace App\Http\Controllers\Admin\Coach\Billing\Config\Invoice;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Action\UpdateIncentiveTypeAction;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;
use App\Src\Config\Action\UpdateInfoPaidAction;
use App\Src\Config\Model\Config;
use App\Src\Config\Presenter\Breadcrumb\EditInfoPaidBreadcrumb;
use App\Src\Config\Request\EditInfoPaidRequest;
use App\Src\Config\Service\InfoPaidForm;
use Illuminate\Support\Facades\Log;


class EditInfoPaidController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $config = Config::first();

        $form = app(InfoPaidForm::class);
        $form->config($config);

        $breadcrumb = new EditInfoPaidBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'config' => $config,
            'form' => $form,
        ]);

        return view('admin.coach.billing.config.invoice.info-paid.form');
    }

    public function update(EditInfoPaidRequest $request)
    {
        try {

            $config = Config::first();
            if (is_null($config)){
                $config = new Config();
            }

            $action = app(UpdateInfoPaidAction::class);
            $action->handle($request, $config);

            flash('Update successfully')->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update Linguameeting paid info.', [
                'config' => $config,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.billing.config.incentive_type.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
