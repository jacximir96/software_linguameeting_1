<?php

namespace App\Src\CourseDomain\Course\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\AssignMakeUpRequest;
use App\Src\StudentDomain\Makeup\Action\Command\CreateMakeupCommand;
use App\Src\StudentDomain\Makeup\Action\Command\MakeupDto;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\StudentDomain\MakeupType\Repository\MakeupTypeRepository;
use App\Src\UserDomain\User\Model\User;
use Spatie\Activitylog\Models\Activity;

class AssignMakeUpAction
{
    private MakeupTypeRepository $makeupTypeRepository;

    private CreateMakeupCommand $createMakeupCommand;

    public function __construct(MakeupTypeRepository $makeupTypeRepository, CreateMakeupCommand $createMakeupCommand)
    {

        $this->makeupTypeRepository = $makeupTypeRepository;
        $this->createMakeupCommand = $createMakeupCommand;
    }

    public function handle(AssignMakeUpRequest $request, Course $course, User $allocator): Course
    {

        $course->load('enrollment', 'enrollment.user');

        $makeupType = $this->makeupTypeRepository->obtainBySlug(MakeupType::SLUG_MANAGER);

        foreach ($course->enrollment as $enrollment) {

            for ($cont = 1; $cont <= $request->number_makeups; $cont++) {

                $dto = new MakeupDto($enrollment, $allocator, $makeupType, $request->is_free);

                $makeup = $this->createMakeupCommand->handle($dto);

                $this->registerActivity($makeup, $dto->allocator());
            }
        }

        return $course;
    }

    private function registerActivity(Makeup $makeup, User $allocator): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
        );

        return activity()
            ->causedBy($allocator)
            ->performedOn($makeup)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.course.makeup.create'));
    }
}
