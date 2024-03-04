<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuidesType extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_guides_type';

    protected $primaryKey = 'id_guide';
}
