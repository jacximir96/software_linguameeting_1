<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Presenter\Log\ActivityLogPresenter;

class ShowActivityController extends Controller
{
    public function __invoke(Course $course)
    {

        $presenter = app(ActivityLogPresenter::class);
        $data = $presenter->handle($course);

        view()->share([
            'course' => $course,
            'data' => $data,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.course.log.activity');
    }
}
