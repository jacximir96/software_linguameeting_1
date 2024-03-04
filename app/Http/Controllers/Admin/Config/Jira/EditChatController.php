<?php

namespace App\Http\Controllers\Admin\Config\Jira;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Action\UpdateIncentiveTypeAction;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;
use App\Src\Config\Action\UpdateChatJiraAction;
use App\Src\Config\Action\UpdateInfoPaidAction;
use App\Src\Config\Model\Config;
use App\Src\Config\Presenter\Breadcrumb\EditChatJiraBreadcrumb;
use App\Src\Config\Presenter\Breadcrumb\EditInfoPaidBreadcrumb;
use App\Src\Config\Request\ChatJiraRequest;
use App\Src\Config\Request\EditInfoPaidRequest;
use App\Src\Config\Service\ChatJiraForm;
use App\Src\Config\Service\InfoPaidForm;
use Illuminate\Support\Facades\Log;


class EditChatController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $config = Config::first();

        $form = app(ChatJiraForm::class);
        $form->config($config);

        $breadcrumb = new EditChatJiraBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'config' => $config,
            'form' => $form,
        ]);

        return view('admin.config.chat-jira.form');
    }

    public function update(ChatJiraRequest $request)
    {
        try {

            $config = Config::first();

            $action = app(UpdateChatJiraAction::class);
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
