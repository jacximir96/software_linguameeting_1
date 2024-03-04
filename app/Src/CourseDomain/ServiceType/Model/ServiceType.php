<?php

namespace App\Src\CourseDomain\ServiceType\Model;

use App\Src\CourseDomain\Course\Model\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceType extends Model implements Auditable
{
    const ID_CONVERSATIONS = 1;

    const ID_EXPERIENCES = 2;

    const ID_COMBINED = 3;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'service_type';

    protected $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function isConversations()
    {
        return $this->id == self::ID_CONVERSATIONS;
    }

    public function isExperiences()
    {
        return $this->id == self::ID_EXPERIENCES;
    }

    public function isCombined()
    {
        return $this->id == self::ID_COMBINED;
    }

    public function hasExperience(): bool
    {
        return $this->isExperiences() or $this->isCombined();
    }

    public function hasConversationGuide ():bool{
        return $this->isConversations() OR $this->isCombined();
    }
}
