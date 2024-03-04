<?php

namespace App\Src\File\Service;

class Attachment
{
    private File $file;

    private string $name;

    public function __construct(File $file, string $name = '')
    {

        $this->file = $file;
        $this->name = $name;
    }

    public function file(): File
    {
        return $this->file;
    }

    public function name(): string
    {

        if (empty($this->name)) {
            return $this->file->filename();
        }

        return $this->name;
    }

    public function mime(): string
    {
        return $this->file->mime();
    }
}
