<?php
namespace App\Http\Controllers\Admin\Student\ExtraSession;


use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Action\CreateExtraSessionAction;
use App\Src\StudentDomain\ExtraSessionType\Repository\ExtraSessionTypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{

    private ExtraSessionTypeRepository $extraSessionTypeRepository;

    public function __construct (ExtraSessionTypeRepository $extraSessionTypeRepository){

        $this->extraSessionTypeRepository = $extraSessionTypeRepository;
    }


    public function __invoke(Enrollment $enrollment)
    {
        try {

            DB::beginTransaction();

            $type = $this->extraSessionTypeRepository->obtainBySlug('additional');

            $action = app(CreateExtraSessionAction::class);
            $action->handle($enrollment, user(), $type);

            DB::commit();

            flash(trans('student.enrollment.extra_session.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create extra session', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.extra_session.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
