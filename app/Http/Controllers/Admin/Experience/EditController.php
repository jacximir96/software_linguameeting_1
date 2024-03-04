<?php

namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Action\UpdateExperienceAction;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\ExperienceDomain\Experience\Request\ExperienceRequest;
use App\Src\ExperienceDomain\Experience\Service\ExperienceForm;
use App\Src\InstructorDomain\Instructor\Action\UpdateInstructorAction;
use App\Src\InstructorDomain\Instructor\Request\UpdateFullInstructorRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditController extends Controller
{
    use Breadcrumable;

    public function configView(Experience $experience)
    {

        $form = app(ExperienceForm::class);
        $form->configToEdit($experience);

        $this->buildBreadcrumbAndSendToView(EditBreadcrumb::SLUG);

        $experienceFiles = $experience->files();

        view()->share([
            'experience' => $experience,
            'experienceFiles' => $experienceFiles,
            'form' => $form,
        ]);

        return view('admin.experience.form');
    }

    public function update(ExperienceRequest $request, Experience $experience)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateExperienceAction::class);
            $action->handle($request, $experience);

            DB::commit();

            flash(trans('experience.update_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update experience', [
                'experience' => $experience,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('experience.error.on_update'))->error();

            return back();
        }
    }
}
