<?php

namespace App\Src\ConversationGuideDomain\GuideOrigin\Model;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class GuideOrigin extends Model implements Auditable
{
    const LINGUAMEETING_ID = 1;

    const LINGROLEARNING_ID = 2;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'guide_origin';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function guide()
    {
        return $this->hasMany(ConversationGuide::class);
    }

    public function isLinguameeting(): bool
    {
        return $this->id == self::LINGUAMEETING_ID;
    }

    public function isLingro(): bool
    {
        return $this->id == self::LINGROLEARNING_ID;
    }
}
