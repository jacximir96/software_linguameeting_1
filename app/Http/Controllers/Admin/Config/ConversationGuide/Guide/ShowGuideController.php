<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Guide;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;

class ShowGuideController extends Controller
{
    use Breadcrumable;

    private GuideRepository $guideRepository;

    public function __construct(GuideRepository $guideRepository)
    {

        $this->guideRepository = $guideRepository;
    }

    public function __invoke(ConversationGuide $guide)
    {

        $guide->load($this->guideRepository->relationshipsWithCourses());

        $this->buildBreadcrumbAndSendToView(ShowBreadcrumb::SLUG);

        view()->share([
            'guide' => $guide,
        ]);

        return view('admin.config.conversation-guide.show');
    }
}
