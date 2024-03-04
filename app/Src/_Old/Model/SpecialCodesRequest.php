<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialCodesRequest extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_special_codes_request';

    protected $primaryKey = 'request_id';
}
