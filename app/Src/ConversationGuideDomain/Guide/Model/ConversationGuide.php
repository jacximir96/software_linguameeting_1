<?php

namespace App\Src\ConversationGuideDomain\Guide\Model;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\ConversationGuideDomain\GuideOrigin\Model\GuideOrigin;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\Language\Model\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConversationGuide extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const ID_IS_LINGUAMEETING = 1;

    const ID_IS_CONTRASENIA = 2;

    const ID_IS_PERCORSI = 3;

    const ID_IS_PASSAPAROLA = 12;

    protected $table = 'conversation_guide';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function chapter()
    {
        return $this->hasMany(Chapter::class);
    }

    public function conversationGuideFile()
    {
        return $this->hasMany(ConversationGuideFile::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function origin()
    {
        return $this->belongsTo(GuideOrigin::class, 'guide_origin_id');
    }

    public function hasBook(): bool
    {
        return $this->conversationGuideFile->count();
    }

    public function hasLingroGuide(): bool
    {
        return match ($this->id) {
            self::ID_IS_CONTRASENIA,
            self::ID_IS_PERCORSI,
            self::ID_IS_PASSAPAROLA => true,
            default => false
        };
    }

    public function hasLingroWithoutGuide(): bool
    {

        if ($this->origin->isLingro()) {

            return ! $this->hasLingroGuide();

        }

        return false;

    }

    public function isLingroContrasenia(): bool
    {
        return self::ID_IS_CONTRASENIA;
    }

    public function isLingroPassaparola(): bool
    {
        return self::ID_IS_PASSAPAROLA;
    }

    public function isLingroPercorsi(): bool
    {
        return self::ID_IS_PERCORSI;
    }

    public function nameWithLanguage(): string
    {

        if ($this->id == self::ID_IS_LINGUAMEETING) {
            return $this->name.' '.$this->language->name;
        }

        return $this->name;
    }
}
