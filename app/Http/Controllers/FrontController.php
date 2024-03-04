<?php

namespace App\Http\Controllers;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use Carbon\Carbon;

class FrontController extends Controller
{


    private ExperienceRepository $experienceRepository;

    public function __construct (ExperienceRepository $experienceRepository){

        $this->experienceRepository = $experienceRepository;
    }

    /**
     * Show the home page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $now = Carbon::now()->setTimezone(config('linguameeting.timezone.by_default_in_experiences'));
        $experienceTimezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

        $experiences = $this->experienceRepository->obtainUpcomingExperiencesWeb($now);

        return view('welcome',[
            'experiences' => $experiences,
            'experienceTimezone' => $experienceTimezone,

        ]);
    }

    public function pricing(){

        return view('web.pricing');
    }

    public function howWorks($slug){

        return view('web.how-it-works.'.$slug);

    }

    public function experiences(string $time = null){

        $now = Carbon::now()->setTimezone(config('linguameeting.timezone.by_default_in_experiences'));

        if ($time == 'all'){
            $experiences = $this->experienceRepository->obtainAllExperiencesWeb();
        }
        elseif($time == 'past'){
            $experiences = $this->experienceRepository->obtainPastExperiencesWeb($now);
        }
        else{
            $time = 'upcoming';
            $experiences = $this->experienceRepository->obtainUpcomingExperiencesWeb($now);

        }

        return view('web.experiences.experiences',[
            'experiences' => $experiences,
            'now' => $now,
            'time' => $time,
            'timezone' => $this->experienceTimezone(),
        ]);
    }

    public function showExperience(Experience $experience){

        $now = Carbon::now()->setTimezone(config('linguameeting.timezone.by_default_in_experiences'));

        return view('web.experiences.show',[
            'experience' => $experience,
            'files' => $experience->files(),
            'now' => $now,
            'timezone' => $this->experienceTimezone(),
        ]);
    }

    public function about(){

        return view('web.about');
    }

    public function support(){

        return view('web.support');
    }

    public function contact(){

        return view('web.contact');
    }

    public function testimonials($slug){

        return view('web.testimonials.'.$slug);

    }

    public function caseStudy($slug){

        return view('web.case-study.'.$slug);

    }

    public function coaches(){

        return view('web.coaches');
    }

    public function policy(){

        return view('web.policy');
    }

    public function terms(){

        return view('web.terms');
    }

    public function searchExperience($slug){

        return view('web.experiences.select');
    }


}
