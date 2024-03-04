<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionsRateOptions extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_sessions_rate_options';

    protected $primaryKey = 'rate_id';
}
