<?php

namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Action\UpdateCoachAction;
use App\Src\CoachDomain\Coach\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\CoachDomain\Coach\Request\CoachRequest;
use App\Src\CoachDomain\Coach\Service\CoachForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    use Breadcrumable;

    public function configView(User $coach)
    {

        $coach->load('coachInfo', 'hobby', 'profileImage');

        $form = app(CoachForm::class);
        $form->configToEdit($coach);

        $this->buildBreadcrumbAndSendToView(EditBreadcrumb::SLUG);

        view()->share([
            'coach' => $coach,
            'form' => $form,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.coach.form');
    }

    public function update(CoachRequest $request, User $coach)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateCoachAction::class);
            $action->handle($request, $coach);

            DB::commit();

            flash(trans('coach.update_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update coach', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
