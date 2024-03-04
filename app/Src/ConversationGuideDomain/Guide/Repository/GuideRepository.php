<?php

namespace App\Src\ConversationGuideDomain\Guide\Repository;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\GuideOrigin\Model\GuideOrigin;
use App\Src\Localization\Language\Model\Language;
use Illuminate\Support\Facades\DB;

class GuideRepository
{
    public function obtainAll()
    {
        return ConversationGuide::query()
            ->with($this->relationships())
            ->orderBy('guide_origin_id', 'asc')
            ->orderBy('language_id', 'asc')
            ->get();
    }

    public function obtainByOriginAndLanguage(GuideOrigin $guideType, Language $language)
    {
        return ConversationGuide::query()
            ->where('guide_origin_id', $guideType->id)
            ->where('language_id', $language->id)
            ->orderBy('name')
            ->get();
    }

    public function obtainFromLinguameetingByLanguage(Language $language): ConversationGuide
    {
        return ConversationGuide::query()
            ->where('guide_origin_id', GuideOrigin::LINGUAMEETING_ID)
            ->where('language_id', $language->id)
            ->orderBy('name')
            ->first();
    }

    public function obtainSpanishLingroWithSpecificOrder()
    {

        return ConversationGuide::query()
            ->where('guide_origin_id', GuideOrigin::LINGROLEARNING_ID)
            ->where('language_id', Language::SPANISH_ID)
            ->orderBy(DB::raw('FIELD(id, 2, 4, 5, 9, 6, 11, 10)'))
            ->get();
    }

    public function obtainLinguameetingSpanish()
    {
        return ConversationGuide::query()
            ->with($this->relationships())
            ->where('id', ConversationGuide::ID_IS_LINGUAMEETING)
            ->first();
    }

    public function relationships(): array
    {
        return ['origin', 'language', 'conversationGuideFile', 'chapter', 'chapter.file'];
    }

    public function relationshipsWithCourses(): array
    {

        $relatioships = $this->relationships();
        $courseRelationships = ['course', 'course.section', 'course.coachingWeek'];

        return array_merge($relatioships, $courseRelationships);
    }
}
