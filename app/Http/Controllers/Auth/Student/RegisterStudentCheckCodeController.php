<?php
namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\StudentDomain\Student\Request\StudentRegisterCheckCodeRequest;


class RegisterStudentCheckCodeController extends Controller
{

    public function configView(){

        return view('auth.register.student.code_form');
    }

    public function checkCode (StudentRegisterCheckCodeRequest $request){

        try{

            $sectionCode = $request->sectionCode();

            $checker = app(SectionCodeChecker::class);
            $checker->checkCodeIsValidForStudentRegister($sectionCode);

            return redirect()->route('get.public.register.student.personal_data', $sectionCode->get());

        }
        catch (SectionCodeNotExists $exception){

            flash('You must provide a valid Class ID. Contact with your university / instructor')->error();

            return back();
        }
        catch (CourseHasFinished $exception){

            flash('The class ID from course has ended. Please contact your instructor.')->error();

            return back();
        }


        catch (\Throwable $exception){

            flash('Error checking section code. Please contact your instructor.');

            return back();

        }
    }
}
