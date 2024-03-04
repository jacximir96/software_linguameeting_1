<?php

namespace App\Http\Controllers\Admin\Config\User;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\Config\Action\UpdateChatJiraAction;
use App\Src\Config\Action\UpdateUserAction;
use App\Src\Config\Model\Config;
use App\Src\Config\Presenter\Breadcrumb\EditUserBreadcrumb;
use App\Src\Config\Request\ChatJiraRequest;
use App\Src\Config\Request\UserRequest;
use App\Src\Config\Service\UserForm;
use Illuminate\Support\Facades\Log;


class EditUserController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $config = Config::first();

        $form = app(UserForm::class);
        $form->config($config);

        $breadcrumb = new EditUserBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'config' => $config,
            'form' => $form,
        ]);

        return view('admin.config.user.form');
    }

    public function update(UserRequest $request)
    {
        try {

            $config = Config::first();

            $action = app(UpdateUserAction::class);
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
