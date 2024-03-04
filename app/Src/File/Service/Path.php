<?php

namespace App\Src\File\Service;

class Path
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/').'/';
    }

    public function get(): string
    {
        return $this->path;
    }

    public function hasFile(string $filename)
    {
        return file_exists($this->path.'/'.$filename);
    }

    public function buildFile(string $filename): File
    {
        return new File($this->path.$filename);
    }
}
