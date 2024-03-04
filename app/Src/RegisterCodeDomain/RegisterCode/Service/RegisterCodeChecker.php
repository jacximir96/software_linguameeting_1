<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Service;

use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeNotExists;
use App\Src\RegisterCodeDomain\RegisterCode\Model\KeyCode;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;

class RegisterCodeChecker
{
    private CodeRepository $codeRepository;

    public function __construct(CodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    public function checkCodeIsValidForRegistration(KeyCode $keyCode)
    {

        $individualCode = $this->codeRepository->findByCode($keyCode);

        if (is_null($individualCode)) {
            throw new CodeNotExists();
        }

        if ($individualCode->isUsed()) {
            throw new CodeIsUsed();
        }
    }
}
