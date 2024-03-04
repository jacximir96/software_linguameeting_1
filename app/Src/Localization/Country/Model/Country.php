<?php

namespace App\Src\Localization\Country\Model;

use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Country extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const USA_ID = 1;

    protected $table = 'country';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function university()
    {
        return $this->hasMany(University::class);
    }

    public function flagFile(): string
    {
        return Str::lower($this->iso2).'.png';
    }
}
