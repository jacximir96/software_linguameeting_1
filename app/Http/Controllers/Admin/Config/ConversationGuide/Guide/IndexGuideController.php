<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Guide;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;

class IndexGuideController extends Controller
{
    use Breadcrumable;

    private GuideRepository $guideRepository;

    public function __construct(GuideRepository $guideRepository)
    {

        $this->guideRepository = $guideRepository;
    }

    public function __invoke()
    {

        $guides = $this->guideRepository->obtainAll();

        $this->buildBreadcrumbAndSendToView(\App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb\IndexBreadcrumb::SLUG);

        view()->share([
            'guides' => $guides,
        ]);

        return view('admin.config.conversation-guide.index');
    }
}
