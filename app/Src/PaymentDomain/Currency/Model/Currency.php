<?php

namespace App\Src\PaymentDomain\Currency\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Currency extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const DOLLAR_ID = 1;

    const EURO_ID = 2;

    protected $table = 'currency';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
