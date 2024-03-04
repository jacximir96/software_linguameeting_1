<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\University\Action\UpdateUniversityAction;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\UniversityDomain\University\Request\UniversityRequest;
use App\Src\UniversityDomain\University\Service\UniversityForm;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    use Breadcrumable;

    public function configView(University $university)
    {
        $form = app(UniversityForm::class);
        $form->configToEdit($university);

        $this->buildBreadcrumbAndSendToView(EditBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
            'university' => $university,
        ]);

        return view('admin.university.form');
    }

    public function update(UniversityRequest $request, University $university)
    {
        try {

            $action = app(UpdateUniversityAction::class);
            $action->handle($request, $university, user());

            flash(trans('university.update_success'))->success();

            return back();

        } catch (\Throwable $exception) {
            Log::error('There is an error when update university', [
                'request' => $request,
                'university' => $university,
                'exception' => $exception,
            ]);

            flash(trans('university.error.on_update'))->error();

            return back();

        }
    }
}
