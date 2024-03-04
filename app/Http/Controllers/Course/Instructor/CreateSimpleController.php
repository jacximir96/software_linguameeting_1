<?php

namespace App\Http\Controllers\Course\Instructor;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Action\CreateInstructorSimpleAction;
use App\Src\InstructorDomain\Instructor\Request\CreateSimpleRequest;
use App\Src\InstructorDomain\Instructor\Service\InstructorSimpleForm;
use App\Src\Localization\Language\Model\Language;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Create an instructor in an university. Simple form with name, last name and email in a modal
 */
class CreateSimpleController extends Controller
{
    public function configView(University $university, Language $language)
    {
        $form = app(InstructorSimpleForm::class);
        $form->configToCreate($university, $language);

        view()->share([
            'form' => $form,
            'withRoleOptions' => true
        ]);

        return view('admin.instructor.base_form');
    }

    public function create(CreateSimpleRequest $request, University $university, Language $language)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateInstructorSimpleAction::class);
            $action->handle($request, $university, $language);

            DB::commit();

            flash(trans('instructor.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create instructor simple', [
                'university' => $university,
                'language' => $language,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
