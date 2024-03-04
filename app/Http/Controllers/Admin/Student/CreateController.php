<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Student\Action\CreateStudentAction;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\StudentDomain\Student\Request\StudentRequest;
use App\Src\StudentDomain\Student\Service\StudentForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(StudentForm::class);
        $form->configToCreate();

        $this->buildBreadcrumbAndSendToView(CreateBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.student.form');
    }

    public function create(StudentRequest $request)
    {
        try {
            DB::beginTransaction();

            $action = app(CreateStudentAction::class);
            $action->handle($request, user());

            DB::commit();

            flash(trans('student.create_success'))->success();

            return redirect()->route('get.admin.student.index');
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create student', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
