<?php

namespace App\Http\Controllers\Admin\Coach\Ranking;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\Ranking\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\Ranking\Service\RankingSearchForm;

class IndexRankingController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke()
    {

        $searchForm = app(RankingSearchForm::class);
        $searchForm->config();

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'searchForm' => $searchForm,
        ]);

        return view('admin.coach.ranking.index');
    }
}
