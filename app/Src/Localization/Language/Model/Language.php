<?php

namespace App\Src\Localization\Language\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Language extends Model implements Auditable
{
    const SPANISH_ID = 1;

    const FRENCH_ID = 2;

    const ITALIAN_ID = 3;

    const ENGLISH_ID = 4;

    const ARABIC_ID = 5;

    const PORTUGUESE_ID = 6;

    const RUSSIAN_ID = 7;

    const CHINESE_ID = 8;

    const JAPANESE_ID = 11;

    const GERMAN_ID = 12;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'language';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function isLingro(): bool
    {
        return $this->is_lingro;
    }

    public function hasLinguameetingGuide(): bool
    {
        return match ($this->id) {
            self::SPANISH_ID,
            self::ITALIAN_ID,
            self::FRENCH_ID => true,
            default => false
        };
    }

    public function isSpanish(): bool
    {
        return $this->id == self::SPANISH_ID;
    }

    public function isFrench(): bool
    {
        return $this->id == self::FRENCH_ID;
    }

    public function isItalian(): bool
    {
        return $this->id == self::ITALIAN_ID;
    }

    public function isSame(Language $other): bool
    {
        return $this->id == $other->id;
    }

    public function weightForOrder(): int
    {

        return match ($this->id) {
            self::SPANISH_ID => 100,
            self::FRENCH_ID => 95,
            self::ITALIAN_ID => 90,
            self::PORTUGUESE_ID => 85,
            self::GERMAN_ID => 80,
            self::RUSSIAN_ID => 75,
            self::JAPANESE_ID => 70,
            self::CHINESE_ID => 65,
            self::ARABIC_ID => 60,
            self::ENGLISH_ID => 55,
            default => 10,

        };
    }

    public function isMajority(): bool
    {
        return match ($this->id) {
            self::SPANISH_ID,
            self::ITALIAN_ID,
            self::FRENCH_ID => true,
            default => false
        };
    }
}
