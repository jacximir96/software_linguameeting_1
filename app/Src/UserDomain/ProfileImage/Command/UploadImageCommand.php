<?php

namespace App\Src\UserDomain\ProfileImage\Command;

use App\Src\File\Command\UploadLocalFileCommand;
use App\Src\UserDomain\ProfileImage\Model\ProfileImage;
use App\Src\UserDomain\ProfileImage\Repository\ProfileImageRepository;
use App\Src\UserDomain\User\Model\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageCommand
{
    private User $user;

    private ProfileImageRepository $profileImageRepository;

    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(ProfileImageRepository $profileImageRepository, UploadLocalFileCommand $uploadLocalFileCommand)
    {
        $this->profileImageRepository = $profileImageRepository;
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(User $user, UploadedFile $file): ProfileImage
    {
        $this->user = $user;

        $profileImage = $this->obtainProfileImageModel();

        return $this->uploadLocalFileCommand->handle($file, $profileImage);
    }

    private function obtainProfileImageModel(): ProfileImage
    {

        $profileImage = $this->profileImageRepository->obtainFromUser($this->user);

        if (is_null($profileImage)) {
            $profileImage = new ProfileImage();
            $profileImage->user_id = $this->user->id;
        }

        return $profileImage;
    }
}
