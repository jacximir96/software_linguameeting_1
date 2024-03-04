<?php
namespace App\Http\Controllers\Auth\Coach;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Action\CreateCoachFrontAction;
use App\Src\CoachDomain\Coach\Request\CoachFrontRequest;
use App\Src\CoachDomain\Coach\Service\CoachFrontForm;
use App\Src\CoachDomain\Level\Model\Level;
use App\Src\Config\Model\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RegisterCoachFrontController extends Controller
{

    public function configView(){

        $form = app(CoachFrontForm::class);
        $form->config();

        return view('auth.register.coach.form', [
            'form' => $form,
        ]);
    }


    public function register (CoachFrontRequest $request){

        try {

            DB::beginTransaction();

            $emailVerifiedAt = null;

            $config = Config::first();
            if ( ! $config->checkEmailExist()){
                $emailVerifiedAt = Carbon::now();
            }

            $request->merge([
                'coach_level_id' => Level::ROOKIE,
                'country_live_id' => $request->country_id,
                'email_verified_at' => $emailVerifiedAt,
                'is_trainee' => true,
                'role_id' => config('linguameeting.user.roles.coach.coach'),
                'active' => true,
            ]);


            $action = app(CreateCoachFrontAction::class);
            $user = $action->handle($request);

            DB::commit();

            Auth::guard()->login($user);

            return redirect()->route('get.coach.dashboard');

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create coach in front web', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.front.error.on_create'))->error();

            return back();
        }
    }
}
