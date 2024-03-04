<?php

namespace App\Http\Controllers\Admin\Student\Help;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\StudentHelp\Action\CreateStudentHelpAction;
use App\Src\StudentDomain\StudentHelp\Request\StudentHelpRequest;
use App\Src\StudentDomain\StudentHelp\Service\StudentHelpForm;
use Illuminate\Support\Facades\Log;


class CreateStudentHelpController extends Controller
{

    public function configView()
    {
        $form = app(StudentHelpForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.student.help.form');
    }

    public function create(StudentHelpRequest $request)
    {
        try {

            $action = app(CreateStudentHelpAction::class);
            $action->handle($request);

            flash(trans('student.help.create.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when create student help.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.help.create.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
