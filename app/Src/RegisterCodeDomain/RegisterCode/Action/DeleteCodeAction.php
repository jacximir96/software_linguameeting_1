<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Action;

use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;

class DeleteCodeAction
{
    public function handle(RegisterCode $code)
    {
        $this->checkCodeNotIsUsed($code);

        $code->delete();
    }

    private function checkCodeNotIsUsed(RegisterCode $code)
    {
        if ($code->isUsed()) {
            throw new CodeIsUsed();
        }
    }
}
