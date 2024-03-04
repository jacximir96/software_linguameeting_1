<?php


namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;


trait Sessionable
{

    public function removeCoachingFormInfoSession(){
        session()->forget('experience_selected');
        session()->forget('coaching-form');
    }
}
