<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityLevels extends Model
{
    const DEMANDING_UNIVERSITIES = 2;
    const NON_DEMANDING_UNIVERSITIES = 3;

    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_university_levels';

    protected $primaryKey = 'level_id';

    public function university()
    {
        return $this->hasMany(University::class, 'level');
    }
}
