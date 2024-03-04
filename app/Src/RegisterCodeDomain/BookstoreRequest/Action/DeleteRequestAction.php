<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Action;

use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\RegisterCode\Action\DeleteCodeAction;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;

class DeleteRequestAction
{
    private CodeRepository $codeRepository;

    private DeleteCodeAction $deleteCodeAction;

    public function __construct(CodeRepository $codeRepository, DeleteCodeAction $deleteCodeAction)
    {
        $this->codeRepository = $codeRepository;
        $this->deleteCodeAction = $deleteCodeAction;
    }

    public function handle(BookstoreRequest $request)
    {
        $this->checkCodeNotIsUsed($request);

        $request->code()->delete();

        $request->delete();
    }

    private function checkCodeNotIsUsed(BookstoreRequest $request)
    {
        if ($this->codeRepository->hasRequestCodeUsed($request)) {
            throw new CodeIsUsed();
        }
    }
}
