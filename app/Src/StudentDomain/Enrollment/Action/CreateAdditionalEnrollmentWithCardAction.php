<?php

namespace App\Src\StudentDomain\Enrollment\Action;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCode;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCreditCardCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\BraintreeSale;
use App\Src\PaymentDomain\Payment\Service\CreditCardPaymentDto;
use App\Src\PaymentDomain\Payment\Service\TransactionContext;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\StudentDomain\Enrollment\Action\Command\CreateEnrollmentCommand;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Request\AdditionalEnrollmentRequest;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleDto;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;


class CreateAdditionalEnrollmentWithCardAction
{

    //construct
    private SectionRepository $sectionRepository;

    private FactoryRole $factoryRole;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    private BraintreeSale $braintreeSale;

    private LinguaMoney $linguaMoney;

    //status
    private AdditionalEnrollmentRequest $request;

    private SectionCode $sectionCode;

    private ?Section $section;

    private User $student;

    private Enrollment $enrollment;

    private SectionCodeChecker $sectionCodeChecker;

    private TransactionResponse $transactionSaleResponse;

    public function __construct(SectionRepository $sectionRepository,
        FactoryRole $factoryRole,
        CreateEnrollmentCommand $createEnrollmentCommand,
        PayWithCreditCardCommand $payWithCreditCardCommand,
        SectionCodeChecker $sectionCodeChecker,
        BraintreeSale $braintreeSale,
        LinguaMoney $linguaMoney)
    {
        $this->sectionRepository = $sectionRepository;
        $this->factoryRole = $factoryRole;
        $this->createEnrollmentCommand = $createEnrollmentCommand;
        $this->payWithCreditCardCommand = $payWithCreditCardCommand;
        $this->sectionCodeChecker = $sectionCodeChecker;
        $this->braintreeSale = $braintreeSale;
        $this->linguaMoney = $linguaMoney;
    }

    public function handle(AdditionalEnrollmentRequest $request, SectionCode $sectionCode, User $student): Enrollment
    {

        $this->initialize($request, $sectionCode, $student);

        $this->checkSectionCodeIsValid();

        $this->processPayment();

        $this->createEnrollment();

        $this->createPayment();

        return $this->enrollment;
    }

    private function initialize(AdditionalEnrollmentRequest $request, SectionCode $sectionCode, User $student)
    {

        $this->request = $request;
        $this->sectionCode = $sectionCode;
        $this->student = $student;

        $this->section = $this->sectionRepository->findByCode($sectionCode->get());
    }

    private function checkSectionCodeIsValid()
    {
        $this->sectionCodeChecker->checkCodeIsValidForStudentRegister($this->sectionCode);
    }

    private function processPayment()
    {

        $amount = $this->linguaMoney->formatToFloat($this->section->course->price());

        $infoSale = new TransactionSaleDto($this->student->name, $this->student->lastname, $amount, $this->request->nonce);

        $context = new TransactionContext('When create a braintree payment registering additional enrollment', [
            'request' => $this->request,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function createEnrollment()
    {
        $this->enrollment = $this->createEnrollmentCommand->handle($this->student, $this->section);
    }

    private function createPayment(): Payment
    {
        $detailCollection = DetailCollection::fromItem($this->enrollment);

        $paymentDto = new CreditCardPaymentDto($detailCollection, $this->student, $this->transactionSaleResponse, $this->enrollment->course()->price());

        return $this->payWithCreditCardCommand->handle($paymentDto);
    }
}
