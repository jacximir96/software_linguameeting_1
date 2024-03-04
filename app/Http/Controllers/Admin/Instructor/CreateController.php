<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Action\CreateInstructorAction;
use App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\InstructorDomain\Instructor\Request\CreateFullInstructorRequest;
use App\Src\InstructorDomain\Instructor\Service\InstructorForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(InstructorForm::class);
        $form->configToCreate();

        $this->buildBreadcrumbAndSendToView(CreateBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.instructor.form');
    }

    public function create(CreateFullInstructorRequest $request)
    {
        try {
            DB::beginTransaction();

            $action = app(CreateInstructorAction::class);
            $instructor = $action->handle($request);

            $instructor->sendEmailVerificationNotificationWithPassword($request->password);

            DB::commit();

            flash(trans('instructor.create_success'))->success();

            return redirect()->route('get.admin.instructor.index');
        } catch (\Throwable $exception) {

            Log::error('There is an error when create instructor', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
