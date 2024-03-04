<?php
namespace App\Src\StudentRole\Coach\Presenter;


use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStatsCollection;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Shared\Model\HashIdable;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentRole\BookSession\Request\BookSessionRequest;
use App\Src\StudentRole\BookSession\Service\Availability\AvailabilitiesTimeHour;
use App\Src\StudentRole\BookSession\Service\Availability\Availability;
use App\Src\StudentRole\BookSession\Service\Availability\AvailabilityLoader;
use App\Src\StudentRole\BookSession\Service\Availability\Filter;
use App\Src\StudentRole\BookSession\Service\Availability\TimeHourSelected;
use App\Src\TimeDomain\Time\Model\Time;
use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use App\Src\TimeDomain\TimeHour\Repository\TimeHourRepository;
use Carbon\Carbon;


class BookSessionCoachPresenter
{

    use HashIdable;

    private CoachRepository $coachRepository;

    private AvailabilityLoader $availabilityLoader;

    private TimeHourRepository $timeHourRepository;

    private ReviewStatsBuilder $reviewStatsBuilder;

    public function __construct(CoachRepository $coachRepository,
                                AvailabilityLoader $availabilityLoader,
                                TimeHourRepository $timeHourRepository,
                                ReviewStatsBuilder $reviewStatsBuilder) {

        $this->coachRepository = $coachRepository;
        $this->availabilityLoader = $availabilityLoader;
        $this->timeHourRepository = $timeHourRepository;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }

    public function handle(BookSessionRequest $request, Enrollment $enrollment): BookSessionCoachResponse
    {

        $availability = $this->initializeAvailability($request);

        $filter = $this->obtainAvailabilityFilter($request, $enrollment);

        $this->availabilityLoader->loadAvailabilityForBookSession($availability, $filter);

        $reviewsStatsCollection = $this->obtainReviewsStats($availability);

        $timeHourSelected = $this->obtainTimeHourSelected($request);

        return new BookSessionCoachResponse($availability, $reviewsStatsCollection, $timeHourSelected);

    }

    //inicializa la disponiblidad con los tramos horarios (mañana, tarde...)
    private function initializeAvailability(BookSessionRequest $request): Availability
    {

        $date = Carbon::parse($request->date);
        $availability = new Availability($date);

        $time = Time::find($request->time_id);
        $timeHours = $this->timeHourRepository->obtainAllFromTime($time);

        foreach ($timeHours as $timeHour) {

            if ($request->filterByTimeHour()) {
                if (! $timeHour->isSameId($request->timeHourIdSelected())) {
                    continue;
                }
            }

            $availabilityHour = new AvailabilitiesTimeHour($timeHour);

            $availability->add($availabilityHour);
        }

        return $availability;
    }

    //configura los filtros usados para obtener la disponibilidad
    private function obtainAvailabilityFilter(BookSessionRequest $request, Enrollment $enrollment): Filter
    {

        if ($request->hasCoachId()) {
            $coachesIds = [$this->decode($request->coachId())];
        } else {

            $coachName = $request->coach ?? '';

            $coachesIds = $this->obtainCoachesIds($enrollment->course(), $coachName);
        }


        $studentTimezone = $enrollment->user->timezone;

        //obtenemos inicio y fin del tramo horario seleccionado (morning, afternoon...)
        $dateSlot = $this->obtainDateSlot($request, $studentTimezone);

        $filter = new Filter($enrollment->course(), $studentTimezone, $dateSlot, $coachesIds);

        return $filter;
    }


    private function obtainCoachesIds(Course $course, string $coachName = ''): array
    {
        if ($course->courseCoach->count()){
            //en el caso de que el curso tenga coaches asignados.
            return $course->courseCoach->pluck('id', 'id')->toArray();
        }

        return $this->coachRepository->obtainCoachesIdsForLanguageAndName($course->language, $coachName);
    }

    private function obtainDateSlot(BookSessionRequest $request, TimeZone $timeZone): DateSlot
    {

        $time = Time::find($request->time_id);
        $timeHours = $this->timeHourRepository->obtainAllFromTime($time);

        $first = $timeHours->first();
        $last = $timeHours->last();

        $start = Carbon::parse($request->dateSession.' '.$first->start, $timeZone->name)->setTimezone('UTC');
        $end = Carbon::parse($request->dateSession.' '.$last->end, $timeZone->name)->setTimezone('UTC');

        return new DateSlot($start, $end);
    }

    private function obtainReviewsStats (Availability $availability):ReviewsStatsCollection{
        return $this->reviewStatsBuilder->buildCollection($availability->obtainCoaches());
    }

    private function obtainTimeHourSelected(BookSessionRequest $request):TimeHourSelected{

        $date = Carbon::parse($request->dateSession);
        $timeHour = TimeHour::find($request->time_id);

        return new TimeHourSelected($date, $timeHour);
    }
}
