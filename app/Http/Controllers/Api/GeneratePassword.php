<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\Password\Service\PasswordService;

class GeneratePassword extends Controller
{
    private PasswordService $password;

    public function __construct(PasswordService $password)
    {
        $this->password = $password;
    }

    public function __invoke()
    {
        return response()->json(['password' => $this->password->generatePassword()]);
    }
}
