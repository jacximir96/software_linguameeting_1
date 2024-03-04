<?php

namespace App\Http\Controllers\Admin\Experience;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Repository\ExperienceCommentRepository;



class CommentsIndexController extends Controller
{

    private ExperienceCommentRepository $experienceCommentRepository;

    public function __construct (ExperienceCommentRepository $experienceCommentRepository){

        $this->experienceCommentRepository = $experienceCommentRepository;
    }

    public function __invoke(Experience $experience)
    {

        $experienceComments = $this->experienceCommentRepository->obtainByExperience($experience);

        view()->share([
            'experience' => $experience,
            'experienceComments' => $experienceComments,

        ]);

        return view('admin.experience.comments_index');
    }
}
