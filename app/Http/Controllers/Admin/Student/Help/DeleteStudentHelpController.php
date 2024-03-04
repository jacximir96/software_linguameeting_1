<?php

namespace App\Http\Controllers\Admin\Student\Help;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\StudentHelp\Action\DeleteStudentHelpAction;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;
use Illuminate\Support\Facades\Log;


class DeleteStudentHelpController extends Controller
{

    public function __invoke(StudentHelp $studentHelp)
    {
        try {

            $action = app(DeleteStudentHelpAction::class);
            $action->handle($studentHelp);

            flash(trans('student.help.delete.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete student help.', [
                'studentHelp' => $studentHelp,
                'exception' => $exception,
            ]);

            flash(trans('student.help.delete.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
