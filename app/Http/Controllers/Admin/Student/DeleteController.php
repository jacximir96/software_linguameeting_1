<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;


use App\Src\StudentDomain\Student\Action\DeleteStudentAction;
use App\Src\StudentDomain\Student\Action\UpdateStudentAction;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\StudentDomain\Student\Request\StudentRequest;
use App\Src\StudentDomain\Student\Service\StudentForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{

    public function __invoke(User $student)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteStudentAction::class);
            $action->handle($student);

            DB::commit();

            flash(trans('student.delete_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete student', [
                'student' => $student,
                'exception' => $exception,
            ]);

            flash(trans('student.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
