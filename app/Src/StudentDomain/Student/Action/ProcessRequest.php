<?php

namespace App\Src\StudentDomain\Student\Action;

use App\Src\StudentDomain\Student\Request\StudentRequest;
use App\Src\UserDomain\ProfileImage\Command\DeleteImageCommand;
use App\Src\UserDomain\ProfileImage\Command\UploadImageCommand;
use App\Src\UserDomain\User\Model\User;

class ProcessRequest
{
    private UploadImageCommand $uploadImageCommand;

    private DeleteImageCommand $deleteImageCommand;

    public function __construct(UploadImageCommand $uploadImageCommand, DeleteImageCommand $deleteImageCommand)
    {

        $this->uploadImageCommand = $uploadImageCommand;
        $this->deleteImageCommand = $deleteImageCommand;
    }

    public function updatePersonalData(StudentRequest $request, User $student): User
    {

        $student->name = $request->name;
        $student->lastname = $request->lastname;
        $student->email = $request->email;
        $student->active = $request->active;
        $student->country_id = $request->country_id;
        $student->timezone_id = $request->timezone_id;

        $student->phone = $request->phone;
        $student->whatsapp = $request->whatsapp;

        if ($request->filled('password')) {
            $student->password = $request->password;
        }

        $student->save();

        return $student;
    }
}
