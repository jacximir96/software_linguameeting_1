<?php

namespace App\Src\CoachDomain\Coach\Action;

use App\Src\CoachDomain\Coach\Request\ICoachRequest;
use App\Src\CoachDomain\CoachInfo\Model\CoachInfo;
use App\Src\UserDomain\Hobby\Model\Hobby;
use App\Src\UserDomain\ProfileImage\Command\DeleteImageCommand;
use App\Src\UserDomain\ProfileImage\Command\UploadImageCommand;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ProcessRequest
{
    private UploadImageCommand $uploadImageCommand;

    private DeleteImageCommand $deleteImageCommand;

    public function __construct(UploadImageCommand $uploadImageCommand, DeleteImageCommand $deleteImageCommand)
    {

        $this->uploadImageCommand = $uploadImageCommand;
        $this->deleteImageCommand = $deleteImageCommand;
    }

    public function updatePersonalData(ICoachRequest $request, User $coach): User
    {

        $coach->name = $request->name;
        $coach->lastname = $request->lastname;
        $coach->email = $request->email;
        $coach->country_id = $request->country_id;
        $coach->country_live_id = $request->country_live_id;
        $coach->timezone_id = $request->timezone_id;

        $coach->phone = $request->phone;
        $coach->whatsapp = $request->whatsapp;
        $coach->skype = $request->skype;

        if ($request->filled('password')) {
            $coach->password = $request->password;
        }

        if ($request->has('active')) {
            $coach->active = $request->active;
        }

        if ($request->has('email_verified')){

            $emailVerified = (bool)$request->email_verified;

            if ( ! $emailVerified){
                $coach->email_verified_at = null;
            }
            else{

                if ( ! $coach->hasEmailVerified()){
                    $coach->email_verified_at = Carbon::now();
                }
            }
        }

        $coach->save();

        $coach->language()->sync($request->language());

        $coach->syncRoles($request->role_id);

        return $coach;
    }

    public function updateCoachInfo(ICoachRequest $request, CoachInfo $coachInfo): CoachInfo
    {

        $coachInfo->coach_level_id = $request->level_id;
        $coachInfo->description = $request->description;
        if ($request->has('is_trainee')) {
            $coachInfo->is_trainee = $request->is_trainee;
        }
        $coachInfo->url_video = $request->filled('url_video') ? $request->url_video : null;

        $coachInfo->save();

        return $coachInfo;
    }

    public function createHobbies(ICoachRequest $request, User $coach)
    {

        if (! $request->has('new_hobbies')) {
            return;
        }

        foreach ($request->new_hobbies as $description) {

            if (is_null($description)) {
                continue;
            }

            $description = trim($description);
            if (empty($description)) {
                continue;
            }

            $hobby = new Hobby();
            $hobby->user_id = $coach->id;
            $hobby->description = $description;
            $hobby->save();
        }
    }

    public function updateProfileImage(ICoachRequest $request, User $coach)
    {

        if ($request->has('delete_profile_image')) {
            $this->deleteProfileImage($coach);
        }

        if ($request->file('profile_image')) {
            $this->uploadImageCommand->handle($coach, $request->profile_image);
        }

    }

    public function deleteProfileImage(User $coach)
    {

        $profileImage = $coach->profileImage;

        if ($profileImage) {
            $this->deleteImageCommand->handle($profileImage);
        }

    }
}
