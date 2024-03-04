<?php
namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Repository\ExperienceRegisterPublicRepository;

class PublicAtteendesIndexController extends Controller
{

    private ExperienceRegisterPublicRepository $experiencePublicUserRepository;

    public function __construct(ExperienceRegisterPublicRepository $experiencePublicUserRepository){
        $this->experiencePublicUserRepository = $experiencePublicUserRepository;
    }

    public function __invoke(Experience $experience)
    {

        $experienceUsers = $this->experiencePublicUserRepository->obtainByExperience($experience);

        view()->share([
            'experience' => $experience,
            'experienceUsers' => $experienceUsers,
        ]);

        return view('admin.experience.public_attendees_index');
    }
}
