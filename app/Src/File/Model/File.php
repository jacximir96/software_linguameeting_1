<?php

namespace App\Src\File\Model;

interface File
{
    public function filename(): string;

    public function mime(): string;

    public function originalName();

    public function keyPath(): string;
}
