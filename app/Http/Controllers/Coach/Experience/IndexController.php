<?php
namespace App\Http\Controllers\Coach\Experience;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Coach\IndexBreadcrumb;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;


class IndexController extends Controller
{
    use Breadcrumable;

    private ExperienceRepository $experienceRepository;

    public function __construct (ExperienceRepository $experienceRepository){

        $this->experienceRepository = $experienceRepository;
    }


    public function __invoke()
    {
        $coach = user();

        $experiences = $this->experienceRepository->obtainExperiencesForCoach($coach);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $experienceTimezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

        view()->share([
            'coach' => $coach,
            'experiences' => $experiences,
            'timezone' => $coach->timezone,
            'experienceTimezone' => $experienceTimezone,
        ]);

        return view('coach.experience.index');
    }
}
