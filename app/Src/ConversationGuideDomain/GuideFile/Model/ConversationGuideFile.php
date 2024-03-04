<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Model;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConversationGuideFile extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes,  \OwenIt\Auditing\Auditable, Fileable;

    const KEY_PATH = 'conversation_guide_file';

    protected $table = 'conversation_guide_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function guideType()
    {
        return $this->belongsTo(ConversationGuide::class);
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }
}
