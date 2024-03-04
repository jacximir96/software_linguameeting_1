<?php

namespace App\Src\File\Command;

use App\Src\File\Model\File;
use App\Src\File\Service\PathBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class UploadLocalFileCommand
{
    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function handle(UploadedFile $file, File $model): Model
    {

        $folder = $this->pathBuilder->buildStorageAbsolutePath($model->keyPath())->get();

        $mime = $file->getMimeType();
        $filename = uniqid().'.'.$file->getClientOriginalExtension();

        $path = $file->move($folder, $filename);

        $model->original_name = $file->getClientOriginalName();
        $model->filename = basename($path);
        $model->mime = $mime;

        $model->save();

        return $model;
    }
}
