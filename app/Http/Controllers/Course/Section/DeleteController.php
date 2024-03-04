<?php

namespace App\Http\Controllers\Course\Section;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Action\DeleteSectionAction;
use App\Src\CourseDomain\Section\Exception\SectionHasStudents;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    use Breadcrumable;

    public function __invoke(Section $section)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteSectionAction::class);
            $action->handle($section);

            DB::commit();

            flash(trans('section.delete_success'))->success();

            return back()->withInput();
        } catch (SectionHasStudents $exception) {

            DB::rollback();

            flash(trans('section.error.students.exists'))->error();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete section', [
                'section' => $section,
                'exception' => $exception,
            ]);

            flash(trans('section.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
