<?php

namespace App\Src\CoachDomain\Coach\Action;

use App\Src\CoachDomain\Coach\Request\ICoachRequest;
use App\Src\UserDomain\Hobby\Model\Hobby;
use App\Src\UserDomain\User\Model\User;

class UpdateCoachAction
{
    private ICoachRequest $request;

    private User $coach;

    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {
        $this->processRequest = $processRequest;
    }

    public function handle(ICoachRequest $request, User $coach): User
    {

        $this->initialize($request, $coach);

        $this->updatePersonalData();

        $this->updateCoachInfo();

        $this->updateHobbies();

        $this->createHobbies();

        $this->updateProfileImage();

        return $this->coach;
    }

    private function initialize(ICoachRequest $request, User $coach)
    {

        $this->request = $request;
        $this->coach = $coach;
    }

    private function updatePersonalData()
    {
        $this->coach = $this->processRequest->updatePersonalData($this->request, $this->coach);
    }

    private function updateCoachInfo()
    {
        $this->processRequest->updateCoachInfo($this->request, $this->coach->coachInfo);
    }

    public function updateHobbies()
    {

        if (! $this->request->filled('hobbies')) {
            return;
        }

        foreach ($this->request->hobbies as $id => $description) {

            $hobby = Hobby::find($id);

            if (empty(trim($description))) {
                $hobby->delete();
            } else {
                $hobby->description = $description;
                $hobby->save();
            }
        }
    }

    public function createHobbies()
    {

        $this->processRequest->createHobbies($this->request, $this->coach);
    }

    private function updateProfileImage()
    {

        $this->processRequest->updateProfileImage($this->request, $this->coach);

    }
}
