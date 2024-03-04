<?php

namespace App\Src\UserDomain\Password\Service;

class PasswordResponse
{
    private $isValid = true;

    private $message = '';

    public function __construct(bool $isValid, string $message)
    {
        $this->isValid = $isValid;
        $this->message = $message;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'is_valid' => $this->isValid,
            'message' => $this->message,
        ];
    }
}
