<?php
namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\CoordinatorRequest\Action\CreateCoordinatorRequestAction;
use App\Src\InstructorDomain\Instructor\Request\PublicRegisterRequest;
use App\Src\Localization\Language\Model\Language;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;


class CreatePublicInstructorAction
{

    //status
    private User $instructor;

    private PublicRegisterRequest $request;

    //construct
    private CreateCoordinatorRequestAction $createCoordinatorRequestAction;


    public function __construct(CreateCoordinatorRequestAction $createCoordinatorRequestAction){
        $this->createCoordinatorRequestAction = $createCoordinatorRequestAction;
    }

    public function handle(PublicRegisterRequest $request):User{

        $this->initialize($request);

        $this->createInstructor();

        $this->assignRole();

        $this->assignUniversity();

        $this->assignLanguage();

        return $this->instructor;
    }

    private function initialize (PublicRegisterRequest $request){
        $this->request = $request;
    }

    private function createInstructor (){

        $this->instructor = new User;
        $this->instructor->password = $this->request->password;

        $this->instructor->name = $this->request->name;
        $this->instructor->lastname = $this->request->lastname;
        $this->instructor->email = $this->request->email;
        $this->instructor->timezone_id = $this->request->timezone_id;
        $this->instructor->country_id = $this->request->country_id;
        $this->instructor->country_live_id = $this->request->country_id;
        $this->instructor->active = false;
        $this->instructor->internal_comment = $this->request->internal_comment ?? '';

        $this->instructor->save();
    }

    private function assignRole (){

        if ($this->request->isCoordinatorRole()){
            //si elige coordinador...-> cambiamos el rol por el del instructor;
            $instructorRol = FactoryRole::obtainInstructor();

            $this->createCoordinatorRequestAction->handle($this->instructor);
        }
        else{
            $instructorRol = FactoryRole::getById($this->request->rol_id);
        }

        $this->instructor->assignRole($instructorRol);
    }


    private function assignUniversity (){
        $this->instructor->university()->sync($this->request->university_id);
    }

    private function assignLanguage()
    {
        $language = Language::find($this->request->language_id);

        $this->instructor->language()->sync($language);
    }
}
