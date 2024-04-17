<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Action\UpdateProfileAction;
use App\Src\UserDomain\User\Presenter\EditProfileBreadcrumb;
use App\Src\UserDomain\User\Request\UpdateProfileRequest;
use App\Src\UserDomain\User\Service\EditProfileForm;
use Illuminate\Support\Facades\Log;

class EditProfileController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(EditProfileForm::class);
        $form->config(\user());

        $this->buildBreadcrumbAndSendToView(EditProfileBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
            'user' => \user(),
        ]);

        return view('user.profile.form');
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $action = app(UpdateProfileAction::class);         
            $action->handle($request, user());
            
            flash(trans('user.profile_update_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when update profile', [
                'request' => $request,
                'user' => user(),
                'exception' => $exception,
            ]);

            flash(trans('user.error.on_update'))->error();

            return back();
        }
    }
}
