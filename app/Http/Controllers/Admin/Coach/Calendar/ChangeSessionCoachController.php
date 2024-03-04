<?php
namespace App\Http\Controllers\Admin\Coach\Calendar;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Action\ChangeSessionCoachAction;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Request\ChangeSessionCoachRequest;
use App\Src\CourseDomain\SessionDomain\Session\Service\ChangeCoachForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ChangeSessionCoachController extends Controller
{

    public function configView(Session $session)
    {

        $form = app(ChangeCoachForm::class);
        $form->config($session);

        view()->share([
            'form' => $form,
            'session' => $session
        ]);

        return view('admin.coach.calendar.change_coach_form');
    }

    public function change(ChangeSessionCoachRequest $request, Session $session){

        try{

            DB::beginTransaction();

            $action = app(ChangeSessionCoachAction::class);
            $action->handle($request, $session);

            DB::commit();

            flash(trans('coach.session.change_coach.success'))->success();

            return view('common.feedback_modal');

        }
        catch (\Throwable $exception){

            DB::rollback();

            Log::error('There is an error when change session coach', [
                'session' => $session,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.session.change_coach.error.on_change'))->error();

            return back();
        }
    }
}
