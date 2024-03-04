<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\MailableController;
use App\Src\StudentDomain\Student\Repository\StudentRepository;
use App\Src\StudentDomain\Student\Service\SendMailForm;
use App\Src\UserDomain\User\Action\SendSimpleEmailAction;
use App\Src\UserDomain\User\Request\SendEmailRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendEmailController extends Controller
{
    use Orderable, MailableController;

    private StudentRepository $studentRepository;

    public function __construct (StudentRepository $studentRepository){

        $this->studentRepository = $studentRepository;
    }

    public function configView()
    {
        $this->configParameters();

        $sendEmailForm = app(SendMailForm::class);
        $sendEmailForm->config();

        view()->share([
            'form' => $sendEmailForm,
        ]);

        return view('user.email.simple_email_form');
    }

    public function send(SendEmailRequest $request)
    {
        try {

            DB::beginTransaction();

            $usersIdsCollection = $this->obtainIdsCollection($request, $this->studentRepository);

            if (is_null($usersIdsCollection)) {

                flash('User ids are required')->error();

                return view('common.feedback_modal');
            }

            $action = app(SendSimpleEmailAction::class);
            $action->handle($usersIdsCollection, $request->buildEmail());

            DB::commit();

            flash('Email sent successfully')->success();

            return view('common.feedback_modal');

        } catch (\Throwable $exception) {

            Log::error('There is an error when sending simple email', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('user.send_mail.error.to_send'))->error();

            return back()->withInput();
        }
    }
}
