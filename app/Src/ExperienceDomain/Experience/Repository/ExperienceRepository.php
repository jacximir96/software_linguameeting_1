<?php

namespace App\Src\ExperienceDomain\Experience\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;


class ExperienceRepository
{
    public function obtainExperiencesForIndex()
    {
        return Experience::query()
            ->with($this->relations())
            ->withCount(['register', 'registerPublic', 'comment', 'donation'])
            ->orderBy('start', 'DESC')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainExperiencesForCoach(User $coach)
    {

        return Experience::query()
            ->with($this->relations())
            ->withCount(['register', 'registerPublic', 'comment', 'donation'])
            ->where('coach_id', $coach->id)
            ->orderBy('start', 'DESC')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainUpcoming(ExperienceFilter $filter)
    {
        $query = Experience::query()
            ->with($this->relations())
            ->select('experience.*');

        if ($filter->filterByMoment()){
            $query->where('start', '>=', $filter->moment()->toDateTimeString());
        }

        $this->applyFilter($query, $filter);

        return $query->orderBy('start')->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainPast(ExperienceFilter $filter)
    {
        $query = Experience::query()
            ->with($this->relations())
            ->select('experience.*');

        if ($filter->filterByMoment()){
            $query->where('start', '<=', $filter->moment()->toDateTimeString());
        }

        $this->applyFilter($query, $filter);

        return $query->orderBy('start')->paginate(config('linguameeting.items_per_page'));

    }

    public function obtainUpcomingExperiencesWeb(Carbon $moment)
    {

        return Experience::query()
            ->with($this->relations())
            ->where('start', '>=', $moment->toDateTimeString())
            ->whereNull('university_id')
            ->whereNull('course_id')
            ->orderBy('start', 'DESC')
            ->get();

    }

    public function obtainPastExperiencesWeb(Carbon $moment)
    {

        return Experience::query()
            ->with($this->relations())
            ->where('start', '<', $moment->toDateTimeString())
            ->whereNull('university_id')
            ->whereNull('course_id')
            ->orderBy('start', 'DESC')
            ->get();

    }

    public function obtainAllExperiencesWeb()
    {

        return Experience::query()
            ->with($this->relations())
            ->whereNull('university_id')
            ->whereNull('course_id')
            ->orderBy('start', 'DESC')
            ->get();

    }

    public function obtainWithAttendanceFromCourse (Course $course){

        return Experience::query()
            ->whereHas('register', function ($query) use($course){
                $query->where('attendance', 1)
                ->whereHas('user.enrollment.section', function ($query) use($course){
                        $query->where('course_id', $course->id);
                    });
            })
            ->get();
    }

    public function applyFilter (Builder $query, ExperienceFilter $filter):Builder{

        if ($filter->filterByCourses()){

            $query->where(function ($query) use ($filter){
                //sean del curso...
                $query->whereIn('course_id', $filter->coursesKeys()->toArray())

                    //...o no tengan ni universidad ni curso
                    ->orWhere(function ($query){
                        $query->whereNull('university_id')->whereNull('course_id');
                    });
            });

        }
        elseif ($filter->filterByUniversities()){

            $query->where(function ($query) use ($filter){
                //o sean de la universidad...
                $query->whereIn('university_id', $filter->universitiesKeys()->toArray())

                    //...o no tengan ni universidad ni curso
                    ->orWhere(function ($query){
                        $query->whereNull('university_id')->whereNull('course_id');
                    });
            });
        }
        else{
            $query->whereNull('university_id');
        }


        return $query;
    }

    public function relations(): array
    {
        return [
            'coach',
            'codeOfferType',
            'comment',
            'course',
            'course.university',
            'file',
            'university',
        ];
    }
}
