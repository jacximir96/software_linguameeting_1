<?php
namespace App\Src\ExperienceDomain\ExperienceRegister\Service;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RegisterList
{

    private Collection $registers;

    public function __construct (){
        $this->registers = collect();
    }

    public function get():Collection{
        return $this->registers;
    }

    public function add (ExperienceRegister $experienceRegister){
        $this->registers->put($experienceRegister->id, $experienceRegister);
    }

    public function canDeleteRegisterNow (Experience $experience, Carbon $nowUTC):bool{

        foreach ($this->registers as $experienceRegister){

            if ($experienceRegister->experience->isFuture($nowUTC)){
                return true;
            }
        }

        return false;
    }
}
