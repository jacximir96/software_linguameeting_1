<?php
namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Student\Action\RestoreStudentAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RestoreController extends Controller
{

    public function __invoke(User $student)
    {
        try {

            DB::beginTransaction();

            $action = app(RestoreStudentAction::class);
            $action->handle($student);

            DB::commit();

            flash(trans('student.restore_success'))->success();

            return redirect()->route('get.admin.student.show', $student->hashId());
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when restore student', [
                'student' => $student,
                'exception' => $exception,
            ]);

            flash(trans('coach.error.on_restore'))->error();

            return back();
        }
    }
}
