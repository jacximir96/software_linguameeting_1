<?php

namespace App\Src\File\Service;

trait Fileable
{
    public function filename(): string
    {
        return $this->filename;
    }

    public function mime(): string
    {
        return $this->mime;
    }

    public function originalName()
    {
        return $this->original_name;
    }
}
