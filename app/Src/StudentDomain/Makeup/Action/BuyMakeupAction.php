<?php
namespace App\Src\StudentDomain\Makeup\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCreditCardCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\BraintreeSale;
use App\Src\PaymentDomain\Payment\Service\CreditCardPaymentDto;
use App\Src\PaymentDomain\Payment\Service\TransactionContext;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Action\Command\CreateMakeupCommand;
use App\Src\StudentDomain\Makeup\Action\Command\MakeupDto;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\Makeup\Request\BuyMakeupRequest;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\StudentDomain\MakeupType\Repository\MakeupTypeRepository;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleDto;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Money\Money;
use Spatie\Activitylog\Models\Activity;


class BuyMakeupAction
{
    //construct
    private CreateMakeupCommand $createMakeupCommand;

    private BraintreeSale $braintreeSale;

    private LinguaMoney $linguaMoney;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    private MakeupTypeRepository $makeupTypeRepository;


    //status
    private BuyMakeupRequest $request;

    private Enrollment $enrollment;

    private User $user;

    private Money $amount;

    private Collection $makeups;

    private TransactionResponse $transactionSaleResponse;

    public function __construct(CreateMakeupCommand $createMakeupCommand,
                                PayWithCreditCardCommand $payWithCreditCardCommand,
                                BraintreeSale $braintreeSale,
                                LinguaMoney $linguaMoney,
                                MakeupTypeRepository $makeupTypeRepository)
    {
        $this->createMakeupCommand = $createMakeupCommand;
        $this->payWithCreditCardCommand = $payWithCreditCardCommand;
        $this->braintreeSale = $braintreeSale;
        $this->linguaMoney = $linguaMoney;
        $this->makeupTypeRepository = $makeupTypeRepository;

        $this->makeups = collect();
    }

    public function handle(BuyMakeupRequest $request, Enrollment $enrollment, User $user):Payment{

        $this->initialize($request, $enrollment, $user);

        $this->configTotalPrice();

        $this->createMakeups();

        $this->processCreditCardPayment();

        return $this->savePayment();
    }

    private function initialize (BuyMakeupRequest $request, Enrollment $enrollment, User $user){
        $this->request = $request;
        $this->enrollment = $enrollment;
        $this->user = $user;
    }

    private function configTotalPrice (){

        $costByOneMakeup = $this->enrollment->course()->priceBuyOneMakeup();

        $this->amount = $costByOneMakeup->multiply($this->request->number_makeups);
    }

    private function createMakeups (){

        $makeupType = $this->makeupTypeRepository->obtainBySlug(MakeupType::SLUG_PURCHASED);

        for ($i=1; $i<=$this->request->number_makeups; $i++){

            $dto = new MakeupDto($this->enrollment, $this->user, $makeupType, false);

            $makeup = $this->createMakeupCommand->handle($dto);

            $this->makeups->push($makeup);

            $this->registerActivity($makeup);
        }
    }

    private function processCreditCardPayment()
    {
        $amount = $this->linguaMoney->formatToFloat($this->amount);

        $infoSale = new TransactionSaleDto($this->user->name, $this->user->lastname, $amount, $this->request->nonce);

        $context = new TransactionContext('Buying a makeups', [
            'request' => $this->request,
            'enrollment' => $this->enrollment,
            'user' => $this->user,
            'amount' => $this->request->amount,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function savePayment():Payment
    {
        $detailCollection = DetailCollection::fromCollection($this->makeups);

        $paymentDto = new CreditCardPaymentDto($detailCollection, $this->user, $this->transactionSaleResponse, $this->amount);

        return $this->payWithCreditCardCommand->handle($paymentDto);
    }

    private function registerActivity (Makeup $makeup):Activity{

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildMakeup($makeup)->buildProperty('makeup', 'Purchased Makeup')
        );

        return activity()
            ->causedBy(user())
            ->performedOn($makeup)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.makeup.buy'));
    }
}
