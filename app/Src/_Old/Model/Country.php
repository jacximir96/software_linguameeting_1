<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_country';

    protected $primaryKey = 'id_country';

    public function university()
    {
        return $this->hasMany(University::class, 'id_country');
    }
}
