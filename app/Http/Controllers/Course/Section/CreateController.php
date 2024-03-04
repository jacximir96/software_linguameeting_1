<?php

namespace App\Http\Controllers\Course\Section;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Action\CreateSectionAction;
use App\Src\CourseDomain\Section\Request\SectionRequest;
use App\Src\CourseDomain\Section\Service\SectionForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use Breadcrumable;

    public function configView(Course $course)
    {
        $form = app(SectionForm::class);
        $form->configToCreate($course);

        view()->share([
            'form' => $form,
            'course' => $course,
        ]);

        return view('admin.section.form');
    }

    public function create(SectionRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateSectionAction::class);
            $action->handle($request, $course, user());

            DB::commit();

            flash(trans('section.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();



            Log::error('There is an error when create section', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('section.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
