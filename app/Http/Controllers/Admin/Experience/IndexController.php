<?php

namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;


class IndexController extends Controller
{
    use Breadcrumable;

    private ExperienceRepository $experienceRepository;

    private TimeZoneRepository $timeZoneRepository;

    public function __construct (ExperienceRepository $experienceRepository){

        $this->experienceRepository = $experienceRepository;
    }

    public function __invoke()
    {

        $experiences = $this->experienceRepository->obtainExperiencesForIndex();

        $linguaMoney = new LinguaMoney();

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'experiences' => $experiences,
            'experienceTimezone' => $this->experienceTimezone(),
            'linguaMoney' => $linguaMoney,
            'timezone' => $this->experienceTimezone(),
        ]);

        return view('admin.experience.index');
    }

}
