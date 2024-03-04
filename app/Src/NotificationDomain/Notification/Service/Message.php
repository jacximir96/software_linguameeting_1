<?php

namespace App\Src\NotificationDomain\Notification\Service;

class Message
{
    private string $message;

    private ?\Throwable $exception;

    private string $extra;

    public function __construct(string $message, ?\Throwable $exception, string $extra)
    {
        $this->message = $message;
        $this->exception = $exception;
        $this->extra = $extra;
    }

    public static function build(string $message, string $extra = '')
    {
        return new self($message, null, $extra);
    }

    public static function buildWithException(string $message, \Throwable $exception, string $extra = '')
    {
        return new self($message, $exception, $extra);
    }

    public function get(): string
    {
        $message = $this->message;

        if ($this->hasException()) {
            $message .= "\r\nFile: ".$this->exception->getFile().' - Line: '.$this->exception->getLine().' - Message: '.$this->exception->getMessage();
        }

        if ($this->hasExtra()) {
            $message .= "\r\nExtra: ".$this->extra;
        }

        return $message;
    }

    private function hasException(): bool
    {
        return ! is_null($this->exception);
    }

    private function hasExtra(): bool
    {
        return ! empty($this->extra);
    }
}
