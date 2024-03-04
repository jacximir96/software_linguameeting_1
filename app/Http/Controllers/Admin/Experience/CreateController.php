<?php

namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Action\CreateExperienceAction;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\ExperienceDomain\Experience\Request\ExperienceRequest;
use App\Src\ExperienceDomain\Experience\Service\ExperienceFiles;
use App\Src\ExperienceDomain\Experience\Service\ExperienceForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $this->buildBreadcrumbAndSendToView(CreateBreadcrumb::SLUG);

        $form = app(ExperienceForm::class);
        $form->configToCreate();

        $experienceFiles = new ExperienceFiles();

        view()->share([
            'experienceFiles' => $experienceFiles,
            'form' => $form,
        ]);

        return view('admin.experience.form');
    }

    public function create(ExperienceRequest $request)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateExperienceAction::class);
            $action->handle($request);

            DB::commit();

            flash(trans('experience.create_success'))->success();

            return redirect()->route('get.admin.experience.index');
        } catch (\Throwable $exception) {

            Log::error('There is an error when create experience', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('experience.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
