<?php

namespace App\Src\StudentDomain\Student\Action\Register;

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
use App\Src\StudentDomain\Student\Request\StudentRegisterPersonalDataRequest;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;

class RegisterStudentWithCodeAction
{
    //construct
    private SectionRepository $sectionRepository;

    private CodeRepository $registerCodeRepository;

    private FactoryRole $factoryRole;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    private PayWithCodeCommand $createPaymentCommand;

    //status
    private StudentRegisterPersonalDataRequest $request;

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

    public function handle(StudentRegisterPersonalDataRequest $request, SectionCode $sectionCode): Enrollment
    {

        $this->initialize($request, $sectionCode);

        $this->checkSectionCodeIsValid();

        $this->checkRegisterCodeIsValid();

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

    private function checkRegisterCodeIsValid()
    {

        $keyCode = new KeyCode($this->request->code);

        $this->registerCodeChecker->checkCodeIsValidForRegistration($keyCode);

        $this->registerCode = $this->registerCodeRepository->findByCode($keyCode);
    }

    private function createUser()
    {

        $university = $this->section->course->university;

        $this->student = new User();

        $this->student->name = $this->request->first_name;
        $this->student->lastname = $this->request->last_name;
        $this->student->email = $this->request->email;
        $this->student->active = true;
        $this->student->country_id = $university->country_id;
        $this->student->timezone_id = $university->timezone_id;

        if ($this->request->filled('password')) {
            $this->student->password = $this->request->password;
        }

        $this->student->save();
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

        $paymentDto = new CodePaymentDto($detailCollection, $this->student, $this->registerCode, $this->enrollment->course()->price());

        return $this->createPaymentCommand->handle($paymentDto);
    }
}
