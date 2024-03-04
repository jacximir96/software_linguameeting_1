<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Action\SendDocumentationAction;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Presenter\InstructionsPresenter;
use App\Src\CourseDomain\Section\Presenter\Log\DocumentationLogPresenter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendDocumentationController extends Controller
{

    public function showView(Section $section)
    {

        $presenter = app(DocumentationLogPresenter::class);
        $data = $presenter->handle($section);

        view()->share([
            'section' => $section,
            'data' => $data,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.section.documentation.index_log');
    }

    public function send(Section $section)
    {
        try {

            //return $this->test($section);

            DB::beginTransaction();

            $action = app(SendDocumentationAction::class);
            $action->handle($section, user());

            DB::commit();

            flash(trans('section.send_documentation_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollBack();

            Log::error('There is an error sending section instruction file', [
                'section' => $section,
                'exception' => $exception,
            ]);

            flash(trans('section.error.on_sending_documentation'))->error();

            return back();
        }
    }

    private function test (Section $section){

        $presenter = app(InstructionsPresenter::class);
        $viewData = $presenter->handle($section);

        view()->share(['viewData' => $viewData]);

        //uncomment for test in view
        //return view('admin.section.file.instructions.index');

        $pdf = PDF::loadView('admin.section.file.instructions.index', compact('section'));
        return $pdf->download($section->summaryFilename());
    }
}
