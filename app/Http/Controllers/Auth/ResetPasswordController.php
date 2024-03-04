<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Request\ResetPasswordRequest;
use App\Src\UserDomain\User\Rule\PasswordRule;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function showResetForm(Request $request)
    {
        $response = $this->validateReset($request);

        if (!empty($response)){
            return redirect()->route('login');
        }

        $token = $request->route()->parameter('token');

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(ResetPasswordRequest $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [new PasswordRule($this, new PasswordService())],
        ];
    }

    protected function redirectTo (){

        if (user()->isCoach()){
            return route('get.coach.dashboard');
        }
        elseif(user()->isStudent()){
            return route('get.student.dashboard');
        }
        elseif(user()->isInstructor()){
            return route('get.instructor.dashboard');
        }

        return $this->redirectTo;
    }

    public function validateReset(Request $request):string
    {
        $credentials =  $request->only('email', 'token');

        if (is_null($user = $this->broker()->getUser($credentials))) {
            return trans(Password::INVALID_USER);
        }

        if (! $this->broker()->tokenExists($user, $request->token)) {
            return trans(Password::INVALID_TOKEN);
        }

        return '';
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = $password;
    }

}
