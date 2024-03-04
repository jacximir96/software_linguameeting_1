<?php

namespace App\Src\UserDomain\User\Rule;

use App\Src\UserDomain\Password\Service\PasswordService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRule implements Rule
{
    private FormRequest $request;

    private string $message = '';

    private PasswordService $password;

    public function __construct(FormRequest $request, PasswordService $password)
    {
        $this->request = $request;
        $this->password = $password;
    }

    public function passes($attribute, $value)
    {
        $hasNotPassword = is_null($value);

        if ($hasNotPassword) {
            return true;
        }

        $response = $this->password->checkPassword($value, $this->request->password_confirmation ?? '');

        if (! $response->isValid()) {
            $this->message = $response->getMessage();

            return false;
        }

        return true;
    }

    public function message()
    {
        if (empty($this->message)) {
            return 'Password invalid';
        }

        return $this->message;
    }
}
