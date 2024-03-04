<?php

namespace App\Http\Controllers\Api\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\SectionInformationForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SectionEditable;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SectionInformationPresenter;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Service\SectionFormApi;
use Illuminate\Support\Facades\Log;

class LoadItemSectionCoachingFormController extends Controller
{
    public function __invoke(Section $section)
    {
        try {
            $sectionInformationForm = app(SectionInformationForm::class);
            $sectionInformationForm->config($section->course, user());

            $form = app(SectionFormApi::class);
            $form->configToEdit($section);

            $presenter = app(SectionInformationPresenter::class);
            $sectionInformationResponse = $presenter->handle($section->course);

            $sectionInformationResponse->setForcedOpenSectionId(0);

            $sectionEditable = new SectionEditable($section, $form);
            view()->share([
                'course' => $section->course,
                'sectionEditable' => $sectionEditable,
                'sectionInformationForm' => $sectionInformationForm,
                'showItemId' => 0,
                'viewData' => $sectionInformationResponse,
            ]);

            return view('admin.course.coaching-form.section-information.section');
        } catch (\Throwable $exception) {
            Log::error('There is an error when load form section in coaching form', [
                'section' => $section,
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}
