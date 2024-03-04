<?php

namespace App\Http\Controllers\Student\Api\Accommodation;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Accommodation\Action\UpdateAccommodationAction;
use App\Src\StudentDomain\Accommodation\Request\AccommodationRequest;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAccommodationController extends Controller
{
    public function __invoke(AccommodationRequest $request, Enrollment $enrollment)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateAccommodationAction::class);
            $accommodation = $action->handle($request, $enrollment);

            DB::commit();

            return response('Accommodation updated successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update accommodation by instructor.', [
                'enrollment' => $enrollment,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('Sorry, there is an error updating accommodation.', 500);
        }
    }
}
