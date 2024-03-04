<?php
namespace App\Http\Controllers\Student\Enrollment;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\StudentDomain\Enrollment\Exception\AlreadyRegisteredInCourse;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\CreateAdditionalBreadcrumb;
use App\Src\StudentDomain\Student\Request\StudentRegisterCheckCodeRequest;

class CreateAdditionalController extends Controller
{
    use Breadcrumable;

    public function configView(){

        $breadcrumb = new CreateAdditionalBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        return view('student.enrollment.additional.code_form');
    }

    public function checkCode (StudentRegisterCheckCodeRequest $request){

        try{

            $student = user();

            $checker = app(SectionCodeChecker::class);
            $checker->checkCodeIsValidForOtherNewRegister($request->sectionCode(), $student);

            return redirect()->route('get.student.enrollment.additional.paid', $request->code);
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
            flash('You are already registered in the course.')->error();

            return back();
        }

        catch (\Throwable $exception){

            flash('Error checking section code. Please contact your instructor.');

            return back();

        }
    }
}
