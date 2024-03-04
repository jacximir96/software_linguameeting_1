<?php

namespace App\Src\ExperienceDomain\Experience\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\ExperienceDomain\CodeOfferType\Model\CodeOfferType;
use App\Src\ExperienceDomain\Experience\Service\ExperienceFiles;
use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\ExperienceDomain\Level\Model\Level;
use App\Src\Localization\Language\Model\Language;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\Shared\Model\HashIdable;
use App\Src\Shared\Model\Morpheable;
use App\Src\Shared\Model\Timezonable;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Money\Money;
use OwenIt\Auditing\Contracts\Auditable;

class Experience extends Model implements Auditable, Morpheable
{
    use Register, Time, HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable, Timezonable;

    const MORPH = 'experience';

    protected $table = 'experience';

    protected $dates = ['start','end', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function codeOfferType()
    {
        return $this->belongsTo(CodeOfferType::class);
    }

    public function comment()
    {
        return $this->hasMany(ExperienceComment::class, 'experience_id');
    }

    public function course (){
        return $this->belongsTo(Course::class)->withTrashed();
    }

    public function file()
    {
        return $this->hasMany(ExperienceFile::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function donation()
    {
        return $this->morphMany(PaymentDetail::class, 'payable');
    }

    public function level (){
        return $this->belongsTo(Level::class)->withTrashed();
    }

    public function register()
    {
        return $this->hasMany(ExperienceRegister::class);
    }

    public function registerPublic()
    {
        return $this->hasMany(ExperienceRegisterPublic::class);
    }

    public function university (){
        return $this->belongsTo(University::class)->withTrashed();
    }

    public function hasRecording(): bool
    {
        if (is_null($this->zoom_video)) {
            return false;
        }

        return ! empty($this->zoom_video);
    }

    public function hasCoach ():bool{
        return !is_null($this->coach_id);
    }

    public function sumDonation(): Money
    {

        $linguaMoney = new LinguaMoney();
        $total = $linguaMoney->buildZero();

        foreach ($this->donation as $detail) {
            $total = $total->add($detail->payment->value);
        }

        return $total;
    }

    public function files(): ExperienceFiles
    {

        $files = new ExperienceFiles();

        foreach ($this->file as $file) {
            $files->add($file);
        }

        return $files;
    }

    public function hasPrice(): bool
    {
        return ! is_null($this->attributes['amount_price']);
    }

    public function showPrice (Carbon $now):bool{
        return $this->hasPrice() AND $this->isFuture($now);
    }

    public function showFree (Carbon $now):bool{
        return !$this->isDonatePublic() AND $this->isFuture($now);
    }

    public function isPaidPrivate():bool
    {
        return (bool) $this->is_paid_private;
    }

    public function isDonatePrivate():bool
    {
        return (bool) $this->is_donate_private;
    }

    public function isDonate ():bool{
        return $this->isPaidPrivate() OR $this->isDonatePublic();
    }

    public function isPaidPublic(): bool
    {
        return (bool) $this->is_paid_public;
    }

    public function isDonatePublic(): bool
    {
        return (bool) $this->is_donate_public;
    }

    public function isFree(): bool
    {
        return ! $this->isPaidPrivate() and ! $this->isPaidPublic();
    }

    public function assignedToUniversityOrCourse ():bool{

        return !is_null($this->university_id) OR !is_null($this->course_id);

    }

    public function coachName():string{

        if ($this->hasCoach()){
            return $this->coach->writeFullNameAndLastName();
        }

        return trim($this->coach_name.' '.$this->coach_lastname);

    }

    public function morphType(): string
    {
        return self::MORPH;
    }
}
