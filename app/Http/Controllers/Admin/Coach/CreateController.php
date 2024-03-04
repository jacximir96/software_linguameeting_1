<?php

namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Action\CreateCoachAction;
use App\Src\CoachDomain\Coach\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\CoachDomain\Coach\Request\CoachRequest;
use App\Src\CoachDomain\Coach\Service\CoachForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use Breadcrumable;

    public function configView()
    {

        $form = app(CoachForm::class);
        $form->configToCreate();

        $this->buildBreadcrumbAndSendToView(CreateBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.coach.form');
    }

    public function create(CoachRequest $request)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateCoachAction::class);
            $coach = $action->handle($request, user());

            DB::commit();

            flash(trans('coach.create_success'))->success();

            return redirect()->route('get.admin.coach.edit', $coach->hashId());
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create coach', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.error.on_create'))->error();

            return back();
        }
    }
}
