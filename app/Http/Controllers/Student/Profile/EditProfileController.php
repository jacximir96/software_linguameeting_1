<?php
namespace App\Http\Controllers\Student\Profile;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Action\UpdateStudentProfileAction;
use App\Src\UserDomain\User\Presenter\EditProfileBreadcrumb;
use App\Src\UserDomain\User\Request\UpdateProfileRequest;
use App\Src\UserDomain\User\Service\EditStudentProfileForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditProfileController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(EditStudentProfileForm::class);
        $form->config(user());

        $this->buildBreadcrumbAndSendToView(EditProfileBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
            'user' => user(),
        ]);

        return view('user.profile.student_form');
    }

    public function update(UpdateProfileRequest $request)
    {
        try {

            DB::beginTransaction();;

            $action = app(UpdateStudentProfileAction::class);
            $action->handle($request, user());

            DB::commit();

            flash(trans('user.profile_update_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update student profile.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('user.error.on_update'))->error();

            return back();
        }
    }
}
