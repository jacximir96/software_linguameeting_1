<?php

namespace App\Http\Controllers\Admin\Student\Makeup;


use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Action\CreateMakeupAction;
use App\Src\StudentDomain\Makeup\Request\MakeupFormRequest;
use App\Src\StudentDomain\Makeup\Service\MakeupForm;
use App\Src\StudentDomain\MakeupType\Repository\MakeupTypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{

    private MakeupTypeRepository $makeupTypeRepository;

    public function __construct (MakeupTypeRepository $makeupTypeRepository){

        $this->makeupTypeRepository = $makeupTypeRepository;
    }

    public function configView(Enrollment $enrollment)
    {

        $form = app(MakeupForm::class);
        $form->configToCreate($enrollment);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.student.makeup.form');
    }

    public function create(MakeupFormRequest $request, Enrollment $enrollment)
    {
        try {

            DB::beginTransaction();

            $type = $this->makeupTypeRepository->obtainBySlug('manager');

            $action = app(CreateMakeupAction::class);
            $action->handle($request, $enrollment, user(), $type);

            DB::commit();

            flash(trans('student.enrollment.makeup.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create makeup', [
                'enrollment' => $enrollment,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.makeup.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
