<?php
namespace App\Src\StudentDomain\Enrollment\Action;


use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCode;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCodeCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\CodePaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\RegisterCodeDomain\RegisterCode\Model\KeyCode;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;
use App\Src\RegisterCodeDomain\RegisterCode\Service\RegisterCodeChecker;
use App\Src\StudentDomain\Enrollment\Action\Command\CreateEnrollmentCommand;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Request\AdditionalEnrollmentRequest;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;


class CreateAdditionalEnrollmentWithCodeAction
{
    //construct
    private SectionRepository $sectionRepository;

    private CodeRepository $registerCodeRepository;

    private FactoryRole $factoryRole;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    private PayWithCodeCommand $createPaymentCommand;

    //status
    private AdditionalEnrollmentRequest $request;

    private SectionCode $sectionCode;

    private Section $section;

    private User $student;

    private Enrollment $enrollment;

    private RegisterCode $registerCode;

    private SectionCodeChecker $sectionCodeChecker;

    private RegisterCodeChecker $registerCodeChecker;

    public function __construct(SectionRepository $sectionRepository,
        CodeRepository $registerCodeRepository,
        FactoryRole $factoryRole,
        CreateEnrollmentCommand $createEnrollmentCommand,
        PayWithCodeCommand $createPaymentCommand,
        SectionCodeChecker $sectionCodeChecker,
        RegisterCodeChecker $registerCodeChecker)
    {
        $this->sectionRepository = $sectionRepository;
        $this->registerCodeRepository = $registerCodeRepository;
        $this->factoryRole = $factoryRole;
        $this->createEnrollmentCommand = $createEnrollmentCommand;
        $this->createPaymentCommand = $createPaymentCommand;
        $this->sectionCodeChecker = $sectionCodeChecker;
        $this->registerCodeChecker = $registerCodeChecker;
    }

    public function handle(AdditionalEnrollmentRequest $request, SectionCode $sectionCode, User $student): Enrollment
    {

        $this->initialize($request, $sectionCode, $student);

        $this->checkSectionCodeIsValid();

        $this->checkRegisterCodeIsValid();

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
        $this->sectionCodeChecker->checkCodeIsValidForOtherNewRegister($this->sectionCode, $this->student);
    }

    private function checkRegisterCodeIsValid()
    {

        $keyCode = new KeyCode($this->request->code);

        $this->registerCodeChecker->checkCodeIsValidForRegistration($keyCode);

        $this->registerCode = $this->registerCodeRepository->findByCode($keyCode);
    }

    private function createEnrollment()
    {

        $this->enrollment = $this->createEnrollmentCommand->handle($this->student, $this->section);
    }

    private function createPayment(): Payment
    {
        $detailCollection = DetailCollection::fromItem($this->enrollment);

        $paymentDto = new CodePaymentDto($detailCollection, $this->student, $this->registerCode, $this->enrollment->course()->price());

        return $this->createPaymentCommand->handle($paymentDto);
    }
}
