<?php
namespace App\Src\StudentRole\BookSession\Service;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Request\SearchCoachRequest;


class ShowCoachInExtraSessionForm extends BaseSearchForm
{
    private SearchCoachRequest $request;

    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    public function __construct(SearchCoachRequest $request, Enrollment $enrollment, SessionOrder $sessionOrder)
    {
        $this->request = $request;
        $this->enrollment = $enrollment;
        $this->sessionOrder = $sessionOrder;

        $this->model = $request->except('_token');
    }

    public function buildAction(): Url
    {
        $route = route('post.student.session.book.extra_session.show_coach', ['enrollment' => $this->enrollment->hashId(), $this->sessionOrder->get()]);

        return new Url($route);
    }

}
