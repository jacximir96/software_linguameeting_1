<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\UniversityDomain\University\Presenter\ShowUniversityPresenter;

class ShowController extends Controller
{
    use Breadcrumable;

    public function __invoke(University $university)
    {
        $presenter = app(ShowUniversityPresenter::class);
        $viewData = $presenter->handle($university);

        $this->buildBreadcrumbAndSendToView(ShowBreadcrumb::SLUG);

        view()->share([
            'experienceTimezone' => $this->experienceTimezone(),
            'timezone' => $this->userTimezone(),
            'viewData' => $viewData,
            'university' => $university,
        ]);

        return view('admin.university.show');
    }
}
