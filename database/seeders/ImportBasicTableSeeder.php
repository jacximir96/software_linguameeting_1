<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Languages;
use App\Src\_Old\Model\Semesters;
use App\Src\CoachDomain\Level\Model\Level;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CoachDomain\SalaryDomain\IncentiveFrequency\Model\IncentiveFrequency;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\SalaryType\Model\SalaryType;
use App\Src\Localization\Language\Model\Language;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\_Old\Model\Country;
use App\Src\_Old\Model\TimeHours;
use App\Src\_Old\Model\Times;
use App\Src\_Old\Model\TimeZones;
use App\Src\PaymentDomain\AccountType\Model\AccountType;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\TimeDomain\Semester\Model\Semester;
use App\Src\TimeDomain\Time\Model\Time;
use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use App\Src\TimeDomain\TimeType\Model\TimeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportBasicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countriesOld = Country::all();
        foreach ($countriesOld as $itemOld){

            $newItem = new \App\Src\Localization\Country\Model\Country();
            $newItem->id = $itemOld->id_country;
            $newItem->name = $itemOld->nom;
            $newItem->iso2 = $itemOld->iso2;
            $newItem->iso3 = $itemOld->iso3;
            $newItem->code = $itemOld->num_code;

            $newItem->save();
        }


        $itemsOld = TimeZones::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new TimeZone();
            $newItem->id = $itemOld->id_zone;
            $newItem->name = $itemOld->large_name;
            $newItem->show = $itemOld->show;
            $newItem->description = $itemOld->description;
            $newItem->code = $itemOld->brief_description;
            $newItem->gmt = $itemOld->gmt;

            $newItem->save();
        }

        $itemsOld = Times::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new Time();
            $newItem->id = $itemOld->time_id;
            $newItem->name = $itemOld->time_name;
            $newItem->save();

        }

        $itemsOld = TimeHours::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new TimeHour();
            $newItem->id = $itemOld->hour_id;
            $newItem->time_id = $itemOld->time_id;
            $newItem->name = $itemOld->hour_name;
            $newItem->start = $itemOld->hour_ini;
            $newItem->end = $itemOld->hour_end;

            $newItem->save();
        }

        $itemsOld = Semesters::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new Semester();
            $newItem->id = $itemOld->semester_id;
            $newItem->name = $itemOld->semester_name;

            $newItem->save();
        }

        $spanishId = 1;
        $italianId = 3;
        $itemsOld = Languages::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new Language();
            $newItem->id = $itemOld->id_language;
            $newItem->name = $itemOld->name_language;

            if ( ($itemOld->id_language == $spanishId) OR ($itemOld->id_language == $italianId) ){
                $newItem->is_lingro = true;
            }

            $newItem->save();
        }


        //Coach level
        $newItem = new Level();
        $newItem->id = 1;
        $newItem->name = 'Excelente';
        $newItem->save();

        $newItem = new Level();
        $newItem->id = 2;
        $newItem->name = 'Muy buenos';
        $newItem->save();

        $newItem = new Level();
        $newItem->id = 3;
        $newItem->name = 'Buenos';
        $newItem->save();

        $newItem = new Level();
        $newItem->id = 4;
        $newItem->name = 'Novatos';
        $newItem->save();


        //0: western,1:paypal,2:TransferWise,3:Moneygram,4:Transferencia
        $methods = ['Western', 'Paypal', 'TransferWise', 'MoneyGram', 'Transfer', 'Credit Card', 'Code', 'Free'];
        foreach ($methods as $methodOld){

            $method = new MethodPayment();
            $method->name = $methodOld;
            $method->save();

        }

        //Currencies
        $currency = new Currency();
        $currency->name = 'Dólar';
        $currency->code = 'USD';
        $currency->save();

        $currency = new Currency();
        $currency->name = 'Euro';
        $currency->code = 'EUR';
        $currency->save();

        //type incentive
        $incentiveType = new SalaryType();
        $incentiveType->name = 'Fixed';
        $incentiveType->save();

        $incentiveType = new SalaryType();
        $incentiveType->name = 'Per Hour';
        $incentiveType->save();

        //
        $discountType = new DiscountType();
        $discountType->name = 'General';
        $discountType->description = '';
        $discountType->save();

        //
        $incentiveType = new IncentiveType();
        $incentiveType->name = 'General';
        $incentiveType->description = '';
        $incentiveType->save();


        //incentive frecuency
        $incentiveType = new IncentiveFrequency();
        $incentiveType->name = 'Puntual';
        $incentiveType->save();

        $incentiveType = new IncentiveFrequency();
        $incentiveType->name = 'Each Month';
        $incentiveType->save();


        //account type
        $accountType = new AccountType();
        $accountType->name = 'Checking Account';
        $accountType->save();

        $accountType = new AccountType();
        $accountType->name = 'Saving Account';
        $accountType->save();
    }
}
