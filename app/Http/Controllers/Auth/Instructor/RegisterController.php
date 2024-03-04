<?php
namespace App\Http\Controllers\Auth\Instructor;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Action\CreatePublicInstructorAction;
use App\Src\InstructorDomain\Instructor\Request\PublicRegisterRequest;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    public function __invoke (PublicRegisterRequest $request){

        try{

            DB::beginTransaction();

            $action = app(CreatePublicInstructorAction::class);
            $instructor = $action->handle($request);

            $instructor->sendEmailVerificationNotificationWithPassword($request->password);

            DB::commit();

            Auth::loginUsingId($instructor->id);

            return redirect()->route('get.instructor.dashboard');

        }

        catch (\Throwable $exception){

            DB::rollBack();

            flash('An error occurred during registration. Please try again. <br> If the problem persists, please contact the administrator.')->error();

            return back()->withInput();
        }
    }
}
