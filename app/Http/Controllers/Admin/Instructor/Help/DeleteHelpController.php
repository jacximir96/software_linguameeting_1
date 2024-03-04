<?php

namespace App\Http\Controllers\Admin\Instructor\Help;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorHelp\Action\DeleteInstructorHelpAction;
use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;
use Illuminate\Support\Facades\Log;


class DeleteHelpController extends Controller
{

    public function __invoke(InstructorHelp $instructorHelp)
    {
        try {

            $action = app(DeleteInstructorHelpAction::class);
            $action->handle($instructorHelp);

            flash(trans('instructor.help.delete.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete instructor help.', [
                'instructorHelp' => $instructorHelp,
                'exception' => $exception,
            ]);

            flash(trans('instructor.help.delete.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
