<?php

namespace App\Src\CourseDomain\CoachingForm\Service;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Model\ValueObject\Url;

class InstructionsFinder
{
    public function printUrlForLinguameetingWithGuide(Course $course): string
    {

        if ($this->isForLinguameetingWithGuide($course)) {

            $language = $course->conversationGuide->language;

            $externalUrl = 'linguameeting.conversation_guides.external_url.guides.linguameeting.'.$language->id;

            $externalUrl = new Url(config($externalUrl));

            return $externalUrl->get();
        }

        return '';
    }

    public function printUrlForLingro(Course $course): string
    {

        if ($course->conversationGuide->hasLingroGuide()) {

            $externalUrl = 'linguameeting.conversation_guides.external_url.guides.lingro.'.$course->conversationGuide->id;

            $externalUrl = new Url(config($externalUrl));

            return $externalUrl->get();
        }

        return '';

    }

    public function printUrlForLingroWithoutGuide(Course $course): string
    {
        $externalUrl = 'linguameeting.conversation_guides.external_url.guides.linguameeting.'.Language::SPANISH_ID;

        $externalUrl = new Url(config($externalUrl));

        return $externalUrl->get();

    }

    public function isForLinguameetingWithGuide(Course $course): string
    {

        if ($course->conversationGuide->origin->isLinguameeting()) {

            if ($course->conversationGuide->language->hasLinguameetingGuide()) {
                return true;
            }
        }

        return false;
    }

    public function isForLinguameetingWithoutGuide(Course $course): bool
    {

        if ($course->conversationGuide->origin->isLinguameeting()) {

            if ($course->conversationGuide->language->hasLinguameetingGuide()) {
                return false;
            }

            return true;

        }

        return false;
    }

    public function obtainCreateAssignmentInstructionsUrl(): Url
    {
        $url = config('linguameeting.conversation_guides.external_url.guides.create_assignment');

        return new Url($url);
    }

    private function obtainLinguameetingExternalUrl(Language $language): Url
    {
        $externalUrl = 'linguameeting.conversation_guides.external_url.guides.linguameeting.'.$language->id;

        $externalUrl = config($externalUrl);

        return new Url($externalUrl);
    }

    private function obtainLingroExternalUrl(ConversationGuide $conversationGuide): Url
    {
        $externalUrl = 'linguameeting.conversation_guides.external_url.guides.lingro.'.$conversationGuide->id;

        $externalUrl = config($externalUrl);

        return new Url($externalUrl);
    }
}
