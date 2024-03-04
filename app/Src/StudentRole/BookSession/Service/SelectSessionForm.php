<?php

namespace App\Src\StudentRole\BookSession\Service;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentRole\BookSession\Request\SearchCoachRequest;
use App\Src\StudentRole\BookSession\Service\Availability\FreeSlot;

class SelectSessionForm extends BaseSearchForm
{
    private SearchCoachRequest $request;

    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    private array $coachSchedulesIds;

    public function __construct(SearchCoachRequest $request, Enrollment $enrollment, SessionOrder $sessionOrder)
    {
        $this->request = $request;
        $this->enrollment = $enrollment;
        $this->sessionOrder = $sessionOrder;

        $this->model = $request->except('_token', 'coach_schedule_id');
        $this->coachSchedulesIds = [];
    }

    public function coachScheduleIds(): array
    {
        return $this->coachSchedulesIds;
    }

    public function buildAction(FreeSlot $freeSlots): Url
    {

        $this->coachSchedulesIds = $freeSlots->coachSchedulesIds();

        $route = route('post.student.session.book.create.store', ['enrollment' => $this->enrollment->id, 'sessionOrder' => $this->sessionOrder->get()]);

        return new Url($route);
    }
}
