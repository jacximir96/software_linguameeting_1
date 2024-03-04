<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Service;

class ErrorMessage
{
    private string $attribute;

    private string $code;

    private string $message;

    public function __construct(string $attribute, string $code, string $message)
    {

        $this->attribute = $attribute;
        $this->code = $code;
        $this->message = $message;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {

        return [
            'attribute' => $this->attribute,
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}
