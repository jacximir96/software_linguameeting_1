<?php
namespace App\Http\Controllers\Public\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Action\RegisterUserWithCodeAction;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Action\RegisterUserWithCreditCardAction;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Mail\PublicRegisterEmail;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Request\PublicRegisterRequest;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Service\PublicRegisterForm;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use App\Src\UserDomain\UserPublic\Action\Command\CreateUserPublicCommand;
use App\Src\UserDomain\UserPublic\Action\Command\UserDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class PublicRegisterController extends Controller
{

    private TimeZoneRepository $timeZoneRepository;

    public function __construct (TimeZoneRepository $timeZoneRepository){

        $this->timeZoneRepository = $timeZoneRepository;
    }

    public function configView(Experience $experience)
    {

        $form = app(PublicRegisterForm::class);
        $form->config($experience);

        view()->share([
            'experience' => $experience,
            'form' => $form,
        ]);

        return view('web.experiences.form.book');
    }

    public function book(PublicRegisterRequest $request, Experience $experience)
    {
        try {

            DB::beginTransaction();;

            $timezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

            $dto = new UserDto($request->first_name, $request->last_name, $request->email, $request->school ?? '', $timezone);
            $action = app(CreateUserPublicCommand::class);
            $user = $action->handle($dto);


            if ($request->isPaymentWithCode()){
                $action = app(RegisterUserWithCodeAction::class);
                $experienceRegisterPublic = $action->handle($request, $experience, $user);
            }
            else{
                $action = app(RegisterUserWithCreditCardAction::class);
                $experienceRegisterPublic = $action->handle($request, $experience, $user);
            }

            Mail::to($request->email)->queue((new PublicRegisterEmail($experienceRegisterPublic, $timezone))->onQueue('emails'));

            DB::commit();

            flash('El registro en la experiencia se ha realizado correctamente.')->success();

            return back();

        }
        catch (TransactionSaleException $exception){

            DB::rollback();

            flash(trans('payment.transaction.error'))->error();

            return back()->withInput();
        }

        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When create a payment for the experience public register.', [
                'experience' => $experience,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('payment.experience.tip.error.general'))->error();

            return back()->withInput();
        }
    }
}
