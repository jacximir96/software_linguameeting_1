<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Action;

use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use Carbon\Carbon;

class ChangeStatusCodeAction
{
    public function handle(RegisterCode $code)
    {
        $this->checkCodeNotIsUsed($code);

        $code->is_used = ! $code->is_used;
        $code->used_at = Carbon::now();

        $code->save();
    }

    private function checkCodeNotIsUsed(RegisterCode $code)
    {
        if ($code->isUsed()) {
            throw new CodeIsUsed();
        }
    }
}
