<?php

namespace App\Src\StudentDomain\Student\Action\Register;

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
use App\Src\StudentDomain\Student\Request\StudentRegisterPersonalDataRequest;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleDto;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;

class RegisterStudentWithCreditCardAction
{
    use UserCreate;

    //construct
    private SectionRepository $sectionRepository;

    private FactoryRole $factoryRole;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    private BraintreeSale $braintreeSale;

    private LinguaMoney $linguaMoney;

    //status
    private StudentRegisterPersonalDataRequest $request;

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

    public function handle(StudentRegisterPersonalDataRequest $request, SectionCode $sectionCode): Enrollment
    {

        $this->initialize($request, $sectionCode);

        $this->checkSectionCodeIsValid();

        $this->processPayment();

        $this->createUser();

        $this->assignRole();

        $this->createEnrollment();

        $this->createPayment();

        return $this->enrollment;
    }

    private function initialize(StudentRegisterPersonalDataRequest $request, SectionCode $sectionCode)
    {

        $this->request = $request;
        $this->sectionCode = $sectionCode;

        $this->section = $this->sectionRepository->findByCode($sectionCode->get());
    }

    private function checkSectionCodeIsValid()
    {
        $this->sectionCodeChecker->checkCodeIsValidForStudentRegister($this->sectionCode);
    }

    private function processPayment()
    {

        $amount = $this->linguaMoney->formatToFloat($this->section->course->price());

        $infoSale = new TransactionSaleDto($this->request->first_name, $this->request->last_name, $amount, $this->request->nonce);

        $context = new TransactionContext('When create a braintree payment registering new student', [
            'request' => $this->request,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function createUser()
    {

        $this->student = $this->createStudent($this->request, $this->section);
    }

    private function assignRole()
    {
        $this->student->assignRole($this->factoryRole->obtainStudent()->id);
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
