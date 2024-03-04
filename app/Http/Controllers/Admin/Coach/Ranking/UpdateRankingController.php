<?php
namespace App\Http\Controllers\Admin\Coach\Ranking;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Ranking\Action\UpdateRankingAction;
use App\Src\CoachDomain\Ranking\Request\RankingRequest;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class UpdateRankingController extends Controller
{

    public function __invoke(RankingRequest $request, User $coach, string $field)
    {
        try {

            $action = app(UpdateRankingAction::class);
            $action->handle($request, $coach, $field);

            return response()->json([
                'message' => 'Ranking updated successfully',
            ], 200);

        }
        catch (\Throwable $exception) {

            Log::error('There is an error when update ranking', [
                'coach' => $coach,
                'field' => $field,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response()->json('Error updating ranking', 500);
        }
    }
}
