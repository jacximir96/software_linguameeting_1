<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Action;

use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Service\CodeGenerator;

class CreateCodeAction
{
    private CodeGenerator $codeGenerator;

    public function __construct(CodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    public function handle(): RegisterCode
    {
        $keyCode = $this->codeGenerator->buildRegisterCode();

        $code = new RegisterCode();
        $code->code = $keyCode->get();
        $code->save();

        return $code;
    }
}
