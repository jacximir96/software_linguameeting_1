<?php

namespace App\Src\Shared\Model\ValueObject;

class EmailContent
{
    private string $subject;

    private string $body;

    public function __construct(string $subject, string $body)
    {

        $this->subject = $subject;
        $this->body = $body;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }
}
