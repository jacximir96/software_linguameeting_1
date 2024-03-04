<?php

namespace App\Src\PaymentDomain\PaymentDetail\Model;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentDetail extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'payment_detail';

    protected $dates = [ 'created_at', 'updated_at', 'deleted_at'];


    public function payable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class)->withTrashed();
    }

    public function isEnrollment():bool{
        return $this->payable_type == Enrollment::MORPH;
    }

    public function enrollment():Enrollment{

        return $this->payable;

    }

    public function writePayable():string{

        return match ($this->payable_type){

            Enrollment::MORPH => 'Enrollment',
            Experience::MORPH => 'Experience',
            ExperienceRegister::MORPH => 'Experience',
            Makeup::MORPH => 'Makeup',
            ExperienceRegisterPublic::MORPH => 'Experience Register Public',

            default => '-'

        };
    }
}

/*
 * Types
 *      enrollemnt: matŕicula
 *      experience: donación/propina para una experiencia
 *      experience_register: registro en una experiencia
 *      experience_register_public: registro en una experiencia como usuario anónimo
 *      makeup
 *
 */
