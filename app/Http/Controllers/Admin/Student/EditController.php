<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;


use App\Src\StudentDomain\Student\Action\UpdateStudentAction;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\StudentDomain\Student\Request\StudentRequest;
use App\Src\StudentDomain\Student\Service\StudentForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    use Breadcrumable;


    public function configView(User $student)
    {

        $form = app(StudentForm::class);
        $form->configToEdit($student);

        $this->buildBreadcrumbAndSendToView(EditBreadcrumb::SLUG);

        view()->share([
            'student' => $student,
            'form' => $form,
        ]);

        return view('admin.student.form');
    }

    public function update(StudentRequest $request, User $student)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateStudentAction::class);
            $action->handle($request, $student);

            DB::commit();

            flash(trans('student.update_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update student', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
