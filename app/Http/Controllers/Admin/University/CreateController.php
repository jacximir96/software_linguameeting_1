<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\University\Action\CreateUniversityAction;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\UniversityDomain\University\Request\UniversityRequest;
use App\Src\UniversityDomain\University\Service\UniversityForm;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(UniversityForm::class);
        $form->configToCreate();

        $this->buildBreadcrumbAndSendToView(CreateBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.university.form');
    }

    public function create(UniversityRequest $request)
    {
        try {

            $action = app(CreateUniversityAction::class);
            $action->handle($request, user());

            flash(trans('university.create_success'))->success();

            return redirect()->route('get.admin.university.index');

        } catch (\Throwable $exception) {
            Log::error('There is an error when create university', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('university.error.on_create'))->error();

            return back();
        }
    }
}
