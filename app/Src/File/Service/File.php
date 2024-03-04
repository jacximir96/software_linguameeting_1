<?php

namespace App\Src\File\Service;

class File
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function path(): string
    {
        return $this->filePath;
    }

    public function filename(): string
    {
        return basename($this->filePath);
    }

    public function mime(): string
    {
        return mime_content_type($this->filePath);
    }

    public function extension ():string{
        return pathinfo($this->filename(), PATHINFO_EXTENSION);
    }
}
