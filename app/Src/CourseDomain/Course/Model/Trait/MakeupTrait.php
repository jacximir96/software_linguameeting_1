<?php
namespace App\Src\CourseDomain\Course\Model\Trait;

use App\Src\CourseDomain\Course\Service\CourseMakeup;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Illuminate\Support\Collection;
use Money\Money;


trait MakeupTrait
{

    public function hasComplimentaryMakeup(): bool
    {
        return (bool) $this->complimentary_makeup;
    }

    public function hasMakeUp(): bool
    {
        return (bool) $this->coachingWeek->filter(function ($coachingWeek) {
            return $coachingWeek->isMakeup();
        })->count();
    }

    public function makeUp(): Collection
    {
        return $this->coachingWeek->filter(function ($coachingWeek) {
            return $coachingWeek->isMakeup();
        });
    }

    public function courseMakeup ():CourseMakeup{
        return new CourseMakeup($this);
    }

    public function priceBuyOneMakeup ():Money{

        $conversationPackage = $this->conversationPackage;
        $type = $conversationPackage->sessionType;
        $code = $type->code;

        $sessionDuration = $conversationPackage->sessionDuration();

        $cents = config('linguameeting.conversation_package.makeup.prices.'.$code.'.'.$sessionDuration->get());

        if (is_null($cents)){
            throw new \InvalidArgumentException('Make-Up price not found');
        }

        $linguaMoney = new LinguaMoney();

        return $linguaMoney->buildFromCents($cents);
    }

    public function printMakeupsNumber(): string
    {
        if (is_null($this->number_makeups)) {
            return 'None';
        }

        if (! $this->number_makeups) {
            return 'None';
        }

        if ($this->number_makeups == self::UNLIMITED_NUMBER_MAKEUPS) {
            return 'Unlimited';
        }

        return (string) $this->number_makeups;
    }

    public function studentsCanBuyMakeup ():bool{
        return $this->buy_makeups;
    }

    public function onlyWeekMakeups ():bool{
        return $this->only_week_makeups;
    }
}
