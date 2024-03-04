<?php
namespace App\Http\Controllers\Experience;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Exception\ExperienceIsPaid;
use App\Src\ExperienceDomain\Experience\Service\RegisterStudentFreeForm;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Action\RegisterUserWithFreeAction;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegister\Mail\RegisterEmail;
use App\Src\ExperienceDomain\ExperienceRegister\Request\UserRegisterFreeRequest;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class RegisterFreeController extends Controller
{

    public function configView(Experience $experience)
    {
        $student = user();

        $form = app(RegisterStudentFreeForm::class);
        $form->config($experience);

        view()->share([
            'experience' => $experience,
            'form' => $form,
            'student' => $student,
        ]);

        return view('student.experience.register_student_free_form');
    }

    public function register(UserRegisterFreeRequest $request, Experience $experience)
    {
        try {

            DB::beginTransaction();

            $timezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

            $action = app(RegisterUserWithFreeAction::class);
            $experienceRegister = $action->handle($request, $experience, user());

            Mail::to(user()->email)->queue((new RegisterEmail($experienceRegister, $timezone))->onQueue('emails'));

            DB::commit();

            flash(trans('payment.experience.register.success'))->success();

            return view('common.feedback_modal');

        }
        catch (UserAlreadyRegisteredInExperience $exception){

            flash(trans('payment.experience.register.error.already_registered'))->error();

            return back()->withInput();

        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When create a payment for the register in free experience.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('payment.experience.register.error.general'))->error();

            return back();
        }
    }
}
