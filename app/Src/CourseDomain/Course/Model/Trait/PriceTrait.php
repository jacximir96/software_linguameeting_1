<?php
namespace App\Src\CourseDomain\Course\Model\Trait;

use Money\Money;


trait PriceTrait
{

    public function hasDiscount(): bool
    {
        if (is_null($this->attributes['amount_discount'])) {
            return false;
        }

        return $this->discount->getAmount() > 0;
    }

    public function hasFree(): bool
    {

        if ($this->isFree()) {
            return true;
        }

        if ($this->hasSectionFree()) {
            return true;
        }

        return false;
    }

    public function hasSectionFree(): bool
    {

        foreach ($this->section as $section) {
            if ($section->isFree()) {
                return true;
            }
        }

        return false;
    }

    public function isFree(): bool
    {
        return $this->is_free;
    }

    public function price(): Money
    {
        if ($this->serviceType->isExperiences()) {

            if (! $this->hasDiscount()) {
                return $this->experienceType->price;
            }

            $price = $this->experienceType->price;

            return $price->subtract($this->discount);
        }

        $conversationPackagePrice = $this->conversationPackage->price;

        if ($this->hasDiscount()) {
            return $conversationPackagePrice->subtract($this->discount);
        }

        return $conversationPackagePrice;
    }
}
