<?php

namespace App\Http\Controllers\Admin\Experience;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;



class AttendeesIndexController extends Controller
{

    private ExperienceRegisterRepository $experienceUserRepository;

    public function __construct(ExperienceRegisterRepository $experienceUserRepository){

        $this->experienceUserRepository = $experienceUserRepository;
    }

    public function __invoke(Experience $experience)
    {

        $experienceUsers = $this->experienceUserRepository->obtainByExperience($experience);

        view()->share([
            'experience' => $experience,
            'experienceUsers' => $experienceUsers,

        ]);

        return view('admin.experience.attendees_index');
    }
}
