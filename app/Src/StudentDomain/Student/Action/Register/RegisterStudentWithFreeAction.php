<?php

namespace App\Src\StudentDomain\Student\Action\Register;

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
use App\Src\StudentDomain\Student\Request\StudentRegisterPersonalDataRequest;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;

class RegisterStudentWithFreeAction
{
    use UserCreate;

    //construct
    private SectionRepository $sectionRepository;

    private FactoryRole $factoryRole;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    private PayFreeCommand $payFreeCommand;

    //status
    private StudentRegisterPersonalDataRequest $request;

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

    public function handle(StudentRegisterPersonalDataRequest $request, SectionCode $sectionCode): Enrollment
    {

        $this->initialize($request, $sectionCode);

        $this->checkSectionCodeIsValid();

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

        $paymentDto = new FreePaymentDto($detailCollection, $this->student, $this->enrollment->course()->price());

        return $this->payFreeCommand->handle($paymentDto);
    }
}
