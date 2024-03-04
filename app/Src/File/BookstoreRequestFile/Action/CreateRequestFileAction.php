<?php

namespace App\Src\File\BookstoreRequestFile\Action;

use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\File\Service\File;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;

class CreateRequestFileAction
{
    public function handle(BookstoreRequest $request, File $file, BookstoreRequestFileType $type): BookstoreRequestFile
    {

        $requestFile = new BookstoreRequestFile();
        $requestFile->bookstore_request_id = $request->id;
        $requestFile->type_id = $type->id;
        $requestFile->original_name = 'BookStore_'.$request->id.'.'.$file->extension();
        $requestFile->filename = $file->filename();
        $requestFile->mime = mime_content_type($file->path());
        $requestFile->save();

        return $requestFile;
    }
}
