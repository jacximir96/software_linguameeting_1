<?php
namespace App\Http\Controllers\Experience;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\ExperienceComment\Action\CreateCommentAction;
use App\Src\ExperienceDomain\ExperienceComment\Request\CreateCommentRequest;
use App\Src\ExperienceDomain\ExperienceComment\Service\CommentForm;
use App\Src\ExperienceDomain\ExperienceRegister\Action\RegisterUserWithCodeAction;
use App\Src\ExperienceDomain\ExperienceRegister\Action\RegisterUserWithCreditCardAction;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegister\Request\UserRegisterRequest;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateCommentController extends Controller
{

    public function configView(Experience $experience)
    {
        $form = app(CommentForm::class);
        $form->config($experience);

        view()->share([
            'experience' => $experience,
            'form' => $form,
        ]);

        return view('student.experience.comment_form');
    }

    public function comment(CreateCommentRequest $request, Experience $experience)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateCommentAction::class);
            $action->handle($request, $experience, user());

            DB::commit();

            flash(trans('experience.comment.user.create_success'))->success();

            return view('common.feedback_modal');

        }
        catch (\Throwable $exception) {



            DB::rollback();

            Log::error('When create a comment for experience.', [
                'experience' => $experience,
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('experience.comment.user.error.general'))->error();

            return back();
        }
    }
}
