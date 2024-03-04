<?php

namespace App\Http\Controllers\Admin\Instructor\Help;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorHelp\Action\CreateInstructorHelpAction;
use App\Src\InstructorDomain\InstructorHelp\Request\InstructorHelpRequest;
use App\Src\InstructorDomain\InstructorHelp\Service\InstructorHelpForm;
use Illuminate\Support\Facades\Log;


class CreateHelpController extends Controller
{

    public function configView()
    {
        $form = app(InstructorHelpForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.instructor.help.form');
    }

    public function create(InstructorHelpRequest $request)
    {
        try {

            $action = app(CreateInstructorHelpAction::class);
            $action->handle($request);

            flash(trans('instructor.help.create.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when create instructor help.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.help.create.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
