<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Action;

use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequest\Request\BookstoreRequest as Request;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Service\CodeGenerator;
use Carbon\Carbon;

class CreateRequestAction
{
    private CodeGenerator $codeGenerator;

    private ?BookstoreRequest $bookstoreRequest = null;

    public function __construct(CodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    public function handle(Request $bookstoreRequest): BookstoreRequest
    {
        $this->createRequest($bookstoreRequest);

        $this->generateCodes($bookstoreRequest->number_codes);

        return $this->bookstoreRequest;
    }

    private function createRequest(Request $bookstoreRequest): BookstoreRequest
    {
        $this->bookstoreRequest = new BookstoreRequest();

        $this->bookstoreRequest->university_id = $bookstoreRequest->university_id;
        $this->bookstoreRequest->num_codes = $bookstoreRequest->number_codes;
        $this->bookstoreRequest->date_request = Carbon::now();

        if ($bookstoreRequest->isExperiencesSelected()) {
            $this->bookstoreRequest->conversation_package_id = $bookstoreRequest->experience_course_type_id;
        } else {
            $this->bookstoreRequest->conversation_package_id = $bookstoreRequest->course_type_id;
        }

        $this->bookstoreRequest->save();

        return $this->bookstoreRequest;
    }

    private function generateCodes(int $numberCodes)
    {
        for ($numCode = 1; $numCode <= $numberCodes; $numCode++) {
            $keyCode = $this->codeGenerator->buildBookstoreCode();

            $code = new RegisterCode();
            $code->bookstore_request_id = $this->bookstoreRequest->id;
            $code->code = $keyCode->get();
            $code->save();
        }
    }
}
