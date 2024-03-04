<?php

namespace App\Src\ExperienceDomain\ExperienceFile\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExperienceFileType extends Model implements Auditable
{
    const ID_VOCABULARY = 1;

    const ID_BANNER = 2;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'experience_file_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function isVocabulary(): bool
    {
        return $this->id == self::ID_VOCABULARY;
    }

    public function isBanner(): bool
    {
        return $this->id == self::ID_BANNER;
    }
}
