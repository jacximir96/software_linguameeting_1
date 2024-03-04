<?php

namespace App\Http\Controllers\Admin\Student\Enrollment;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Action\DeleteEnrollmentAction;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{


    public function __invoke(Enrollment $enrollment)
    {

        try{

            DB::beginTransaction();

            $action = app(DeleteEnrollmentAction::class);
            $action->handle($enrollment);

            DB::commit();

            flash(trans('student.enrollment.delete.success'))->success();

            return view('common.feedback_modal');

        }
        catch (\Throwable $exception){

            DB::rollback();

            Log::error('There is an error when delete enrollment', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.delete.error.on_delete'))->error();

            return back()->withInput();

        }


    }
}
