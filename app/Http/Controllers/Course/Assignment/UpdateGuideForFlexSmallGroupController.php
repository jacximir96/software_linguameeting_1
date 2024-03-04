<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\CourseAssignment\OneGuideForFlexSmallGroupUpdateAction;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateGuideForFlexSmallGroupController extends Controller
{
    public function __invoke(AssignmentRequest $request, Section $section, int $sessionNumber)
    {

        try {
            DB::beginTransaction();

            $flexSession = new FlexSession($sessionNumber);

            $action = app(OneGuideForFlexSmallGroupUpdateAction::class);
            $action->handle($request, $section, $flexSession);

            DB::commit();

            return response('Guide assigned successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update guide in flex with one one one', [
                'section' => $section,
                'sessionNumber' => $sessionNumber,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}
