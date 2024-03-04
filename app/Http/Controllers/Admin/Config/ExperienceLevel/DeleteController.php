<?php
namespace App\Http\Controllers\Admin\Config\ExperienceLevel;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Level\Action\DeleteExperienceLevelAction;
use App\Src\ExperienceDomain\Level\Exception\LevelHasExperience;
use App\Src\ExperienceDomain\Level\Model\Level;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{

    public function __invoke(Level $level)
    {
        try {

            $action = app(DeleteExperienceLevelAction::class);
            $action->handle($level);

            flash(trans('config.accommodation_type.delete_success'))->success();

            return back();

        }
        catch (LevelHasExperience $exception){

            flash(trans('config.experience_level.delete_error_has_experience'))->error();

            return back();


        } catch (\Throwable $exception) {

            Log::error('There is an error when delete accommodation type.', [
                'accommodationType' => $level,
                'exception' => $exception,
            ]);

            flash(trans('config.experience_level.error.on_delete'))->error();

            return back();
        }
    }
}
