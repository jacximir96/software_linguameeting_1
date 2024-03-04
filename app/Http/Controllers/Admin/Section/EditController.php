<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Action\UpdateSectionAction;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Request\SectionRequest;
use App\Src\CourseDomain\Section\Service\SectionForm;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    use Breadcrumable;

    public function configView(Section $section)
    {
        $form = app(SectionForm::class);
        $form->configToEdit($section);

        view()->share([
            'course' => $section->course,
            'form' => $form,
            'section' => $section,
        ]);

        return view('admin.section.form');
    }

    public function update(SectionRequest $request, Section $section)
    {
        try {
            $action = app(UpdateSectionAction::class);
            $action->handle($request, $section, user());

            flash(trans('section.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {
            Log::error('There is an error when update section', [
                'request' => $request,
                'section' => $section,
                'exception' => $exception,
            ]);

            flash(trans('section.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
