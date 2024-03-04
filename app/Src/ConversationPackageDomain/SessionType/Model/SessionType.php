<?php

namespace App\Src\ConversationPackageDomain\SessionType\Model;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\CourseDomain\Course\Model\StudentsNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SessionType extends Model implements Auditable
{
    const ONE_ON_ONE_ID = 1;

    const SMALL_GROUPS = 2;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'session_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function conversationPackage()
    {
        return $this->hasMany(ConversationPackage::class);
    }

    public function defaultStudentsBySession(): StudentsNumber
    {
        return match ($this->id) {
            self::ONE_ON_ONE_ID => StudentsNumber::create(1),
            self::SMALL_GROUPS => StudentsNumber::create(4),
            default => StudentsNumber::create(0)
        };
    }

    public function isSame(self $otherSessionType): bool
    {
        return $this->id == $otherSessionType->id;
    }

    public function isSmallGroup(): bool
    {
        return $this->id == self::SMALL_GROUPS;
    }

    public function isOneAndOne(): bool
    {
        return ! $this->isSmallGroup();
    }
}
