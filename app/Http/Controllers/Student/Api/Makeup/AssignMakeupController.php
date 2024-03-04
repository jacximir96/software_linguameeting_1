<?php
namespace App\Http\Controllers\Student\Api\Makeup;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Action\AssignMakeupByInstructorAction;
use App\Src\StudentDomain\Makeup\Request\AssignMakeupByInstructorFormRequest;
use App\Src\StudentDomain\MakeupType\Repository\MakeupTypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AssignMakeupController extends Controller
{

    private MakeupTypeRepository $makeupTypeRepository;


    public function __construct (MakeupTypeRepository $makeupTypeRepository){
        $this->makeupTypeRepository = $makeupTypeRepository;
    }


    public function __invoke(AssignMakeupByInstructorFormRequest $request, Enrollment $enrollment)
    {
        try {

            DB::beginTransaction();

            $type = $this->makeupTypeRepository->obtainBySlug('instructor');

            $action = app(AssignMakeupByInstructorAction::class);
            $action->handle($request, $enrollment, user(), $type);

            DB::commit();

            if ($request->num_makeups > 1){
                $message = 'Makeups assigned successfully';
            }
            else{
                $message = 'Makeup assigned successfully';
            }

            return response($message, 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when assign makeups by instructor', [
                'enrollment' => $enrollment,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('Sorry, there is an error assigning makeups.', 500);
        }
    }
}
