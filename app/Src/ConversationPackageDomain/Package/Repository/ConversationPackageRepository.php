<?php

namespace App\Src\ConversationPackageDomain\Package\Repository;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\Course\Model\SessionSetup;

class ConversationPackageRepository
{

    public function obtainAllForConfig(){

        return ConversationPackage::query()
            ->with('sessionType')
            ->orderBy('session_type_id')
            ->orderBy('experiences')
            ->orderBy('number_session')
            ->orderBy('duration_session')
            //->orderByRaw('CONCAT(number_session,"_",duration_session) ASC')
            //->orderBy('name')
            //->orderByRaw('LENGTH(name) ASC')
            ->get();
    }

    public function obtainForAssignToCourse(SessionType $sessionType, SessionSetup $sessionSetup, bool $withExperiences = false): ?ConversationPackage
    {
        return ConversationPackage::query()
            ->where('session_type_id', $sessionType->id)
            ->where('number_session', $sessionSetup->sessionNumber()->get())
            ->where('duration_session', $sessionSetup->sessionDuration()->get())
            ->where('experiences', $withExperiences)
            ->where('code_active', 1)
            ->first();
    }

    public function obtainForAvailability(SessionType $sessionType, bool $withExperiences)
    {
        return ConversationPackage::query()
            ->where('session_type_id', $sessionType->id)
            ->where('experiences', $withExperiences)
            ->where('code_active', 1)
            ->orderBy('number_session')
            ->orderBy('duration_session')
            ->get();
    }

    public function obtainSameButWithExperienceOrNull(ConversationPackage $conversationPackage): ?ConversationPackage
    {
        return ConversationPackage::query()
            ->where('session_type_id', $conversationPackage->session_type_id)
            ->where('number_session', $conversationPackage->number_session)
            ->where('duration_session', $conversationPackage->duration_session)
            ->where('experiences', 1)
            ->where('code_active', 1)
            ->first();
    }

    public function obtainSameButWithouthExperienceOrNull(ConversationPackage $conversationPackage): ?ConversationPackage
    {
        return ConversationPackage::query()
            ->where('session_type_id', $conversationPackage->session_type_id)
            ->where('number_session', $conversationPackage->number_session)
            ->where('duration_session', $conversationPackage->duration_session)
            ->where('experiences', 0)
            ->where('code_active', 1)
            ->first();
    }
}
