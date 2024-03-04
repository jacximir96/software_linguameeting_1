<?php
namespace App\Http\Controllers\Coach\Profile;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Action\UpdateCoachProfileAction;
use App\Src\UserDomain\User\Presenter\EditProfileBreadcrumb;
use App\Src\UserDomain\User\Request\CoachProfileRequest;
use App\Src\UserDomain\User\Service\EditCoachProfileForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditProfileController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(EditCoachProfileForm::class);
        $form->config(user());

        $this->buildBreadcrumbAndSendToView(EditProfileBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
            'user' => user(),
        ]);

        return view('user.profile.coach_form');
    }

    public function update(CoachProfileRequest $request)
    {
        try {

            DB::beginTransaction();;

            $action = app(UpdateCoachProfileAction::class);
            $action->handle($request, user());

            DB::commit();

            flash(trans('user.profile_update_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update coach profile.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('user.error.on_update'))->error();

            return back();
        }
    }
}
