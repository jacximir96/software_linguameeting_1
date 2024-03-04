<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Action\AssignMakeUpAction;
use App\Src\CourseDomain\Course\Service\AssignMakeUpForm;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Request\AssignMakeUpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AssignMakeUpController extends Controller
{
    public function configView(Section $section)
    {
        $form = app(AssignMakeUpForm::class);
        $form->configForSection($section);

        view()->share([
            'section' => $section,
            'form' => $form,
        ]);

        return view('admin.course.form_assign_make_up');
    }

    public function assign(AssignMakeUpRequest $request, Section $section)
    {
        try {

            DB::beginTransaction();

            $action = app(AssignMakeUpAction::class);
            $action->handle($request, $section, user());

            DB::commit();

            flash(trans('section.makeup.assign.success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when assign make up in a section.', [
                'section' => $section,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('section.makeup.assign.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}
