<?php

namespace App\Http\Controllers\Admin\Student\Makeup;


use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Makeup\Action\UpdateMakeupAction;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\Makeup\Request\MakeupFormRequest;
use App\Src\StudentDomain\Makeup\Service\MakeupForm;
use App\Src\StudentDomain\MakeupType\Repository\MakeupTypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{

    private MakeupTypeRepository $makeupTypeRepository;

    public function __construct (MakeupTypeRepository $makeupTypeRepository){

        $this->makeupTypeRepository = $makeupTypeRepository;
    }

    public function configView(Makeup $makeup)
    {

        $form = app(MakeupForm::class);
        $form->configToEdit($makeup);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.student.makeup.form');
    }

    public function update(MakeupFormRequest $request, Makeup $makeup)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateMakeupAction::class);
            $action->handle($request, $makeup);

            DB::commit();

            flash(trans('student.enrollment.makeup.update_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update makeup', [
                'makeup' => $makeup,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.makeup.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
