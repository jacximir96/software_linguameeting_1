<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialCodes extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_special_codes';

    protected $primaryKey = 'id_special_code';
}
