<?php
namespace App\Src\ExperienceDomain\ExperienceRegister\Action;

use App\Src\ExperienceDomain\Experience\Exception\ExperienceAlreadyStarted;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\PaymentDomain\Payment\Exception\PaymentHasBeenRefunded;
use App\Src\PaymentDomain\PaymentDetail\Service\PaymentDetailFinder;
use App\Src\PaymentDomain\PaymentRefund\Action\Command\CreateRefundCommand;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


class DeleteRegisterAction
{
    //construct
    private CreateRefundCommand $createRefundCommand;

    //status
    private ExperienceRegister $experienceRegister;

    private User $user;

    public function __construct (CreateRefundCommand $createRefundCommand){

        $this->createRefundCommand = $createRefundCommand;
    }

    public function handle(ExperienceRegister $experienceRegister, User $user):ExperienceRegister{

        $this->initialize($experienceRegister, $user);

        $this->checkDeleteIsPossible();

        $payment = $experienceRegister->payment();

        if ($payment){
            if ($payment->methodPayment->isCreditCard()){
                $this->makeRefund();
            }
        }

        $experienceRegister->delete();

        return $experienceRegister;
    }

    private function initialize (ExperienceRegister $experienceRegister, User $user){
        $this->experienceRegister = $experienceRegister;
        $this->user = $user;
    }

    private function checkDeleteIsPossible(){

        $now = Carbon::now();

        if ( ! $this->experienceRegister->experience->isFuture($now)){
            throw new ExperienceAlreadyStarted();
        }
    }

    private function makeRefund (){

        try{
            $this->createRefundCommand->handle($this->experienceRegister->payment, $this->user);
        }
        catch (PaymentHasBeenRefunded $exception){
            return;
        }
    }
}
