<?php
namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCode;
use App\Src\StudentDomain\Student\Action\Register\RegisterStudentWithCodeAction;
use App\Src\StudentDomain\Student\Action\Register\RegisterStudentWithCreditCardAction;
use App\Src\StudentDomain\Student\Action\Register\RegisterStudentWithFreeAction;
use App\Src\StudentDomain\Student\Request\StudentRegisterPersonalDataRequest;
use App\Src\StudentDomain\Student\Service\PersonalDataRegisterForm;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use App\Src\ThirdPartiesDomain\Braintree\Service\Braintree;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeNotExists;
use App\Src\UserDomain\User\Action\SendNewRegisterEmailAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RegisterStudentPersonalDataController extends Controller
{
    private SectionRepository $sectionRepository;

    private Braintree $braintree;

    public function __construct (SectionRepository $sectionRepository, Braintree $braintree){

        $this->sectionRepository = $sectionRepository;

        $this->braintree = $braintree;
    }

    public function configView(string $sectionCode){

        try{

            $section = $this->sectionRepository->findByCode($sectionCode);

            if (is_null($section)){
                throw new SectionCodeNotExists();
            }

            $form = app(PersonalDataRegisterForm::class);
            $form->config($section);

            return view('auth.register.student.personal_data_form', [
                'form' => $form,
                'section' => $section
            ]);

        }
        catch (SectionCodeNotExists $exception){

            flash(trans('payment.section_code.public.register.not_exists'))->error();
            return redirect()->route('get.public.register.student.code');
        }

    }

    public function register (StudentRegisterPersonalDataRequest $request, string $sectionCode){

        try{

            DB::beginTransaction();

            $sectionCode = new SectionCode($sectionCode);

            if ($request->isCodePayment()){
                $action = app(RegisterStudentWithCodeAction::class);
                $enrollment = $action->handle($request, $sectionCode);
            }
            elseif ($request->isCreditCardPayment()){

                $action = app(RegisterStudentWithCreditCardAction::class);
                $enrollment = $action->handle($request, $sectionCode);

            }
            elseif ($request->isFreePayment()){
                $action = app(RegisterStudentWithFreeAction::class);
                $enrollment = $action->handle($request, $sectionCode);
            }

            $action = app(SendNewRegisterEmailAction::class);
            $action->handle($enrollment);

            DB::commit();

            Auth::loginUsingId($enrollment->student_id);

            flash('Welcome to Linguameeting. Select your sessions.')->success();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (SectionCodeNotExists $exception){

            flash('You must provide a valid Class ID. Contact with your university / instructor')->error();

            return back()->withInput();
        }
        catch (CourseHasFinished $exception){

            flash('The class ID from course has ended. Please contact your instructor.')->error();

            return back()->withInput();
        }
        catch (CodeNotExists $exception){

            flash('The register code not exists. Please contact your instructor.')->error();

            return back()->withInput();
        }
        catch (CodeIsUsed $exception){

            flash('The register already being used. Please contact your instructor.')->error();

            return back()->withInput();
        }
        catch (TransactionSaleException $exception){

            flash('Sorry, there was an error processing the payment, refresh the page and try again, if the problem persists, please contact support.')->error();

            return back()->withInput();

        }
        catch (\Throwable $exception){

            DB::rollBack();


        }
    }
}
