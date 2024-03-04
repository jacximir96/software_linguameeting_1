<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\DenyAccess\Service\CheckerDenyAccess;
use App\Src\InstructorDomain\Instructor\Action\UpdateInstructorAction;
use App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\InstructorDomain\Instructor\Request\UpdateFullInstructorRequest;
use App\Src\InstructorDomain\Instructor\Service\InstructorForm;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    use Breadcrumable, Presentable;

    private RoleChecker $checkerRole;

    public function __construct(RoleChecker $checkerRole)
    {

        $this->checkerRole = $checkerRole;
    }

    public function configView(User $instructor)
    {

        $form = app(InstructorForm::class);
        $form->configToEdit($instructor);

        $presenter = $this->obtainPresenter($this->checkerRole, $instructor->rol());
        $data = $presenter->handle($instructor);

        $this->buildBreadcrumbAndSendToView(EditBreadcrumb::SLUG);

        $checkerDenyAccess = new CheckerDenyAccess($instructor->denyAccess);

        view()->share([
            'checkerDenyAccess' => $checkerDenyAccess,
            'checkerRole' => $this->checkerRole,
            'data' => $data,
            'form' => $form,
            'instructor' => $instructor,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.instructor.form');
    }

    public function update(UpdateFullInstructorRequest $request, User $instructor)
    {
        try {
            DB::beginTransaction();

            $action = app(UpdateInstructorAction::class);
            $action->handle($request, $instructor);

            DB::commit();

            flash(trans('instructor.update_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when update instructor', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_update'))->error();

            return back();
        }
    }
}
