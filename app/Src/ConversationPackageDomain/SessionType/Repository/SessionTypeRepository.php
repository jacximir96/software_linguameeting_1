<?php

namespace App\Src\ConversationPackageDomain\SessionType\Repository;

use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;

class SessionTypeRepository
{
    public function find(int $id): ?SessionType
    {
        return SessionType::find($id);
    }

    public function obtainByCode(string $code): ?SessionType
    {
        return SessionType::where('code', $code)->first();
    }

    public function obtainSmallGroup(): SessionType
    {
        return SessionType::find(SessionType::SMALL_GROUPS);
    }

    public function obtainOneAndOne(): SessionType
    {
        return SessionType::find(SessionType::ONE_ON_ONE_ID);
    }
}
