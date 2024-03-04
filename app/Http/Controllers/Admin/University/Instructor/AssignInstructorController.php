<?php

namespace App\Http\Controllers\Admin\University\Instructor;

use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\Instructor\Action\AssignUniversityAction;
use App\Src\UniversityDomain\Instructor\Request\AssignUniversityRequest;
use App\Src\UniversityDomain\Instructor\Service\AssignUniversityForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;

class AssignInstructorController extends Controller
{
    public function configView(User $instructor)
    {
        $form = app(AssignUniversityForm::class);
        $form->configToAssign($instructor);

        view()->share([
            'form' => $form,
            'instructor' => $instructor,
        ]);

        return view('admin.university.instructor.assign_instructor_form');
    }

    public function assign(AssignUniversityRequest $request, User $instructor)
    {
        try {
            DB::beginTransaction();

            $action = app(AssignUniversityAction::class);
            $action->handle($request, $instructor);

            DB::commit();

            flash(trans('university.instructor.assign_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when assign instructor to university', [
                'instructor' => $instructor,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_update'))->error();
        }

        return back();
    }
}
