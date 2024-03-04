<?php

namespace App\Http\Controllers\Admin\Coach\Ranking;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Ranking\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;

use App\Src\CoachDomain\Ranking\Service\RankingForm;
use App\Src\CoachDomain\Ranking\Service\RankingSearchForm;
use App\Src\Localization\Language\Model\Language;


class SearchRankingController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke()
    {
        $language = Language::find(request()->language_id);
        $coaches = $this->coachRepository->obtainCoachesForLanguage($language);

        $searchForm = app(RankingSearchForm::class);
        $searchForm->config();

        $rankingForm = app(RankingForm::class);
        $rankingForm->config();

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coaches' => $coaches,
            'language' => $language,
            'rankingForm' => $rankingForm,
            'searchForm' => $searchForm,
        ]);

        return view('admin.coach.ranking.index_form');
    }
}
