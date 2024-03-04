<?php

namespace App\Http\Controllers\Api\Options\Guides;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\ConversationGuideDomain\GuideOrigin\Model\GuideOrigin;
use App\Src\Localization\Language\Model\Language;

class IndexController extends Controller
{
    private GuideRepository $guideRepository;

    public function __construct(GuideRepository $guideRepository)
    {
        $this->guideRepository = $guideRepository;
    }

    public function obtainGuideByOriginAndLanguage(GuideOrigin $guideOrigin, Language $language)
    {

        if ($guideOrigin->isLingro() and $language->isSpanish()) {
            $guides = $this->guideRepository->obtainSpanishLingroWithSpecificOrder();
        } else {
            $guides = $conversationGuides = $this->guideRepository->obtainByOriginAndLanguage($guideOrigin, $language);
        }

        $conversationGuides = $guides->map(function ($conversationGuide) {
            return [
                'id' => $conversationGuide->id,
                'name' => $conversationGuide->name,
            ];
        });

        return response()->json(['items' => $conversationGuides]);
    }
}
