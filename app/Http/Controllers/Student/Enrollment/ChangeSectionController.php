<?php
namespace App\Http\Controllers\Student\Enrollment;


use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Exception\NumberSessionsNotEqual;
use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Exception\SectionIsFull;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\ErrorDeletingEnrollmentSession;
use App\Src\StudentDomain\Enrollment\Action\ChangeCourseAction;
use App\Src\StudentDomain\Enrollment\Action\ChangeSectionAction;
use App\Src\StudentDomain\Enrollment\Exception\AlreadyRegisteredInCourse;
use App\Src\StudentDomain\Enrollment\Exception\ErrorDeletingEnrollment;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Request\ChangeSectionRequest;
use App\Src\StudentDomain\Enrollment\Service\ChangeSectionForm;
use Illuminate\Support\Facades\DB;

class ChangeSectionController extends Controller
{

    private SectionRepository $sectionRepository;

    public function __construct (SectionRepository $sectionRepository){

        $this->sectionRepository = $sectionRepository;
    }

    public function configView(Enrollment $enrollment)
    {

        $student = user();

        $form = app(ChangeSectionForm::class);
        $form->config($enrollment);

        view()->share([
            'enrollment' => $enrollment,
            'form' => $form,
            'student' => $student,
        ]);

        return view('student.enrollment.change_form');
    }

    public function change(ChangeSectionRequest $request, Enrollment $enrollment)
    {
        try{

            $student = user();

            $checker = app(SectionCodeChecker::class);
            $checker->checkCodeIsValidForOtherNewRegister($request->sectionCode(), $student);

            $newSection = $this->sectionRepository->findByCode($request->sectionCode()->get());

            if ($newSection->course->isSame($enrollment->course())){
                //solo cambia la sección

                DB::beginTransaction();

                $action = app(ChangeSectionAction::class);
                $action->handle($enrollment, $newSection,  user());

                DB::commit();

                flash('Section changed successfully. Close this window to continue.')->success();

                return view('common.feedback_modal');

            }
            else{

                DB::beginTransaction();

                $action = app(ChangeCourseAction::class);
                $action->handle($enrollment, $newSection,  user());

                DB::commit();

                flash('Course changed successfully. However, since it is a new course, you will need to select a new coaching session. <br> Please Go to the <strong> Dashboard</strong> to select your new session.')->success();

                return view('common.feedback_modal');
            }
        }
        catch (SectionCodeNotExists $exception){

            flash('You must provide a valid Class ID. Contact with your university / instructor')->error();

            return back();
        }
        catch (CourseHasFinished $exception){

            flash('The class ID from course has ended. Please contact your instructor.')->error();

            return back();
        }
        catch (AlreadyRegisteredInCourse $exception){

            flash('The Class ID you entered is associated with the class you are registered. If you want to change section/course, you will need to enter a different Class ID.')->error();

            return back();
        }
        catch (NumberSessionsNotEqual $exception){

            flash('This new course requires a different number of sessions. You will need to contact Support. They can do a refund to purchase access again.')->error();

            return back();

        }
        catch (ErrorDeletingEnrollmentSession $exception){

            flash('Error deleting sessions.')->error();

            return back();

        }
        catch (ErrorDeletingEnrollment $exception){

            flash('Error deleting enrollment.')->error();

            return back();

        }
        catch (\Throwable $exception){

            flash('Error checking section code. Please contact your instructor.')->error();

            return back();
        }
    }
}
