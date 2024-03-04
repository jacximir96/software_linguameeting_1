<?php
namespace App\Src\StudentDomain\Enrollment\Action;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Service\SectionCode;
use App\Src\CourseDomain\Section\Service\SectionCodeChecker;
use App\Src\PaymentDomain\Payment\Action\Command\PayFreeCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\FreePaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\StudentDomain\Enrollment\Action\Command\CreateEnrollmentCommand;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Request\AdditionalEnrollmentRequest;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;


class CreateAdditionalEnrollmentWithFreeAction
{


    //construct
    private SectionRepository $sectionRepository;

    private FactoryRole $factoryRole;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    private PayFreeCommand $payFreeCommand;

    //status
    private AdditionalEnrollmentRequest $request;

    private SectionCode $sectionCode;

    private Section $section;

    private User $student;

    private Enrollment $enrollment;

    private SectionCodeChecker $sectionCodeChecker;

    public function __construct(SectionRepository $sectionRepository,
        FactoryRole $factoryRole,
        CreateEnrollmentCommand $createEnrollmentCommand,
        PayFreeCommand $payFreeCommand,
        SectionCodeChecker $sectionCodeChecker)
    {
        $this->sectionRepository = $sectionRepository;
        $this->factoryRole = $factoryRole;
        $this->createEnrollmentCommand = $createEnrollmentCommand;
        $this->payFreeCommand = $payFreeCommand;
        $this->sectionCodeChecker = $sectionCodeChecker;
    }

    public function handle(AdditionalEnrollmentRequest $request, SectionCode $sectionCode, User $student): Enrollment
    {

        $this->initialize($request, $sectionCode, $student);

        $this->checkSectionCodeIsValid();

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

    private function createEnrollment()
    {
        $this->enrollment = $this->createEnrollmentCommand->handle($this->student, $this->section);
    }

    private function createPayment(): Payment
    {
        $detailCollection = DetailCollection::fromItem($this->enrollment);

        $paymentDto = new FreePaymentDto($detailCollection, $this->student, $this->enrollment->course()->price());

        return $this->payFreeCommand->handle($paymentDto);
    }
}
