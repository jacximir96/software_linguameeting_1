<?php

namespace App\Src\Config\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class Config extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'config';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function checkEmailExist ():bool{
        return (bool)$this->check_email_exist;
    }
}
