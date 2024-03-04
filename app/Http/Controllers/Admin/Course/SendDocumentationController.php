<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Action\SendDocumentationAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Presenter\Log\DocumentationLogPresenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendDocumentationController extends Controller
{
    public function showView(Course $course)
    {

        $presenter = app(DocumentationLogPresenter::class);
        $data = $presenter->handle($course);

        view()->share([
            'course' => $course,
            'data' => $data,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.course.documentation.index_log');
    }

    public function send(Course $course)
    {
        try {

            DB::beginTransaction();

            $action = app(SendDocumentationAction::class);
            $action->handle($course, user());

            DB::commit();

            flash(trans('course.send_documentation_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollBack();

            Log::error('There is an error when send section instruction file', [
                'section' => $course,
                'exception' => $exception,
            ]);

            flash(trans('course.error.on_sending_documentation'))->error();

            return back();
        }
    }
}
