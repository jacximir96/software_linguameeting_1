<?php
namespace App\Http\Controllers\Student\Enrollment;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCode;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeNotExists;
use App\Src\StudentDomain\Enrollment\Action\CreateAdditionalEnrollmentWithCardAction;
use App\Src\StudentDomain\Enrollment\Action\CreateAdditionalEnrollmentWithCodeAction;
use App\Src\StudentDomain\Enrollment\Action\CreateAdditionalEnrollmentWithFreeAction;
use App\Src\StudentDomain\Enrollment\Exception\AlreadyRegisteredInCourse;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\CreateAdditionalBreadcrumb;
use App\Src\StudentDomain\Enrollment\Request\AdditionalEnrollmentRequest;
use App\Src\StudentDomain\Enrollment\Service\AdditionalEnrollmentForm;
use App\Src\StudentDomain\Student\Action\Register\RegisterStudentWithCodeAction;
use App\Src\StudentDomain\Student\Action\Register\RegisterStudentWithCreditCardAction;
use App\Src\StudentDomain\Student\Action\Register\RegisterStudentWithFreeAction;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use App\Src\UserDomain\User\Action\SendNewRegisterEmailAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreatePaidAdditionalController extends Controller
{
    use Breadcrumable;

    private SectionRepository $sectionRepository;

    public function __construct (SectionRepository $sectionRepository){

        $this->sectionRepository = $sectionRepository;
    }

    public function configView(string $sectionCode){

        $student = user();

        $breadcrumb = new CreateAdditionalBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        try{

            $section = $this->sectionRepository->findByCode($sectionCode);

            if (is_null($section)){
                throw new SectionCodeNotExists();
            }

            $form = app(AdditionalEnrollmentForm::class);
            $form->config($section);

            $linguaMoney = new LinguaMoney();

            return view('student.enrollment.additional.paid_form', [
                'form' => $form,
                'linguaMoney' => $linguaMoney,
                'section' => $section,
                'student' => $student,
            ]);

        }
        catch (SectionCodeNotExists $exception){

            flash('You must provide a valid Class ID. Contact with your university / instructor')->error();
            return redirect()->route('get.student.enrollment.additional.code');
        }
    }

    public function create (AdditionalEnrollmentRequest $request, string $sectionCode){

        try{

            DB::beginTransaction();

            $sectionCode = new SectionCode($sectionCode);

            $student = user();

            if ($request->isCodePayment()){
                $action = app(CreateAdditionalEnrollmentWithCodeAction::class);
                $action->handle($request, $sectionCode, $student);
            }
            elseif ($request->isCreditCardPayment()){

                $action = app(CreateAdditionalEnrollmentWithCardAction::class);
                $action->handle($request, $sectionCode, $student);

            }
            elseif ($request->isFreePayment()){
                $action = app(CreateAdditionalEnrollmentWithFreeAction::class);
                $action->handle($request, $sectionCode, $student);
            }

            DB::commit();

            flash('Has sido asignado al nuevo curso correctamente.')->success();

            return redirect()->route('get.student.dashboard');

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

            Log::error('Error creating additional course', [
                'sectionCode' => $sectionCode,
                'student' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash('Sorry, there was an error creating new course. Refresh the page and try again, if the problem persists, please contact support')->error();

            return back()->withInput();
        }
    }
}
