<?php

namespace App\Src\ConversationPackageDomain\Package\Model;

use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Model\SessionDuration;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConversationPackage extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'conversation_package';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'price' => MoneyCast::class,
    ];


    protected function descriptionWithIsbn(): Attribute
    {
        $money = new LinguaMoney();

        $description = $this->name.' - '.$this->isbn.' - '.$money->format($this->price);

        return Attribute::make(
            get: fn ($value) => $description,
        );
    }

    protected function descriptionWithOnlyIsbn(): Attribute
    {
        $description = $this->name.' - '.$this->isbn;

        return Attribute::make(
            get: fn ($value) => $description,
        );
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function sessionType()
    {
        return $this->belongsTo(SessionType::class);
    }

    public function isEqualNumberOfSession(int $number): bool
    {
        return $this->number_session == $number;
    }

    public function isCustomNumberOfSession(): bool
    {
        return ($this->number_session != 6) and ($this->number_session != 12);
    }

    public function isEqualDurationOfSession(int $duration): bool
    {
        return $this->duration_session == $duration;
    }

    public function obtainSessionSetup(): SessionSetup
    {
        return SessionSetup::createWithInteger($this->number_session, $this->duration_session);
    }

    public function hasExperiences(): bool
    {
        return (bool) $this->experiences;
    }

    public function isExperienceChange(bool $otherValue): bool
    {
        return $this->hasExperiences() != $otherValue;
    }

    public function writeExperienceOption(): string
    {
        if ($this->hasExperiences()) {
            return trans('conversation_package.experience.for-credit');
        }

        return trans('conversation_package.experience.optional');
    }

    public function formatPrice(): string
    {
        $money = new LinguaMoney();

        return $money->format($this->price);
    }

    public function sessionDuration(): SessionDuration
    {
        return SessionDuration::create($this->duration_session);
    }

    public function isSame (ConversationPackage $other):bool{
        return $this->id == $other->id;
    }

    public function getOrderAttribute(){
        return $this->number_session.'_'.$this->duration_session;
    }
}
