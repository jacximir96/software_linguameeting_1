<?php
namespace App\Http\Controllers\Instructor\Students;


use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Exception\NumberSessionsNotEqual;
use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\ErrorDeletingEnrollmentSession;
use App\Src\InstructorDomain\Students\Request\ChangeSectionRequest;
use App\Src\StudentDomain\Enrollment\Action\ChangeCourseAction;
use App\Src\StudentDomain\Enrollment\Action\ChangeSectionAction;
use App\Src\StudentDomain\Enrollment\Exception\AlreadyRegisteredInCourse;
use App\Src\StudentDomain\Enrollment\Exception\ErrorDeletingEnrollment;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeSectionController extends Controller
{

    private SectionRepository $sectionRepository;

    public function __construct (SectionRepository $sectionRepository){

        $this->sectionRepository = $sectionRepository;
    }

    public function __invoke(ChangeSectionRequest $request, Enrollment $enrollment)
    {
        try{


            $checker = app(SectionCodeChecker::class);

            $checker->checkCodeIsValidForOtherNewRegister($request->sectionCode(), $enrollment->user);

            $newSection = $this->sectionRepository->findByCode($request->sectionCode()->get());

            if ($newSection->course->isSame($enrollment->course())){

                DB::beginTransaction();

                $action = app(ChangeSectionAction::class);
                $action->handle($enrollment, $newSection,  user());

                DB::commit();

                flash('Section changed successfully. Close this window to continue.')->success();

                return back();

            }
            else{

                DB::beginTransaction();

                $action = app(ChangeCourseAction::class);
                $newEnrollment = $action->handle($enrollment, $newSection,  user());

                DB::commit();

                flash('Course changed successfully. However, since it is a new course, the student will need to select a new coaching session.')->success();

                return redirect()->route('get.instructor.students.show', $newEnrollment->hashId());
            }
        }
        catch (SectionCodeNotExists $exception){

            flash('You must provide a valid Class ID.')->error();

            return back();
        }
        catch (CourseHasFinished $exception){

            flash('The class ID from course has ended.')->error();

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

            Log::error('There is an error when changing student to section/course.', [
                'request' => $request,
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash('Error changing student to section/course. Refresh the page and try again, if the problem persists, please contact support.')->error();

            return back();
        }
    }
}
