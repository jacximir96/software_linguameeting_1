<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatesOptions extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_rates_options';

    protected $primaryKey = 'rate_option_id';
}
