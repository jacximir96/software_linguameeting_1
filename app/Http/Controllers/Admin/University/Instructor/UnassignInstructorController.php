<?php

namespace App\Http\Controllers\Admin\University\Instructor;

use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\Instructor\Action\UnassignUniversityAction;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnassignInstructorController extends Controller
{
    public function delete(User $instructor, University $university)
    {
        try {
            DB::beginTransaction();

            $action = app(UnassignUniversityAction::class);
            $action->handle($instructor, $university);

            DB::commit();

            flash(trans('university.instructor.delete_success'))->success();

            return back();
        } catch (ModelNotFoundException $exception) {
            flash(trans('instructor.error.not_found'))->error();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when delete instructor to university', [
                'instructor' => $instructor,
                'university' => $university,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_update'))->error();
        }

        return back();
    }
}
