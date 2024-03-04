<?php

namespace App\Src\ExperienceDomain\CodeOfferType\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CodeOfferType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'code_offer_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
