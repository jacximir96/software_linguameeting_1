<?php
namespace App\Http\Controllers\Experience;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Exception\ExperienceAlreadyStarted;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Action\DeleteRegisterAction;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\RegisterNotFound;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteRegisterController extends Controller
{

    private ExperienceRegisterRepository $experienceRegisterRepository;

    public function __construct (ExperienceRegisterRepository $experienceRegisterRepository){

        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }


    public function __invoke(Experience $experience)
    {
        try {

            $experienceRegister = $this->experienceRegisterRepository->obtainByExperienceAndUser($experience, user());
            
            if (is_null($experienceRegister)){
              throw new RegisterNotFound();
            }
            
            DB::beginTransaction();

            // $action = app(DeleteRegisterAction::class);        
            // $action->handle($experienceRegister, user());

            $exp = ExperienceRegister::where('experience_id', $experience->id)->first()->delete();
            DB::commit();

            flash(trans('experience.comment.user.create_success'))->success();

            return back();

        }
        catch (RegisterNotFound $exception){

            flash(trans('experience.register.delete.error.register_not_found'))->error();

            return back();

        }
        catch (ExperienceAlreadyStarted $exception){

            DB::rollback();

            flash(trans('experience.register.delete.error.already_started'))->error();

            return back();
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When delete a register in one experience.', [
                'experience' => $experience,
                'user' => user(),
                'exception' => $exception,
            ]);

            flash(trans('experience.register.delete.error.general'))->error();

            return back();
        }
    }
}
