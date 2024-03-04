<?php
namespace App\Http\Controllers\Student\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Action\JoinExperienceAction;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class JoinExperienceController extends Controller
{

    private ExperienceRegisterRepository $experienceRegisterRepository;

    public function __construct (ExperienceRegisterRepository $experienceRegisterRepository){

        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }

    public function __invoke(Experience $experience)
    {
        try {

            $experienceRegister = $this->experienceRegisterRepository->obtainByExperienceAndUser($experience, user());

            if ( ! $experienceRegister->hasJoinedAt()){

                DB::beginTransaction();

                $action = app(JoinExperienceAction::class);
                $action->handle($experienceRegister, user());

                DB::commit();
            }

            return response()->json(['message' => 'Joined successfully', 'url_join' => $experience->url_join], 200);
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When student join in an experience.', [
                'user' => user(),
                'experience' => $experience,
                'exception' => $exception,
            ]);

            return response()->json([
                'message' => 'Error joined to experience',
            ], 200);
        }
    }
}
