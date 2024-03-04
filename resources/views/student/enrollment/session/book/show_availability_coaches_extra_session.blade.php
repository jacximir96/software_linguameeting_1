@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-calendar-day me-1"></i>
               Extra Session
            </span>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 col-md-6">

                     <span class="d-inline-block fw-bold bg-corporate-color text-white p-1 rounded">
                            Extra Session
                        </span>


                    @if ( ! $course->isFlex())

                        <span class="d-inline-block fw-bold bg-corporate-color text-white p-1 rounded">
                            Session {{$sessionOrder->get()}}
                        </span>


                        @if (isset($coachingWeek))
                            <span class="d-inline-block ms-3 fw-bold text-corporate-dark-color">
                            @if ($coachingWeek->isMakeup())
                                    <span class="d-inline-block me-2 fw-bold text-corporate-dark-color">Additional Week</span>
                                @else
                                    <span class="d-inline-block me-2 fw-bold">Week {{$coachingWeek->sessionOrder()}}</span>
                                @endif
                            <span class="d-inline-block me-1">From</span>
                            <span class="fst-italic">
                                {{toMonthDayAndYear($coachingWeek->start_date, $utcTimezoneName)}} to {{toMonthDayAndYear($coachingWeek->end_date, $utcTimezoneName)}}
                            </span>
                        </span>
                        @endif
                    @endif



                    <span class="d-block mt-3 text-corporate-dark-color">
                        Revisa las horas y coaches que hemos encontrado disponibles para ti.
                    </span>

                    <span class="small">*revisar estos textos.. claro.</span>
                </div>

                <div class="col-12 col-md-6">

                    <div class="row ">
                        <div class="col-12">
                            <span class="d-block fw-bold bg-corporate-color text-white p-1 rounded">
                                If these times do not work for you, please click here to find more options.
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @include('student.enrollment.session.book.search_form', ['form' => $searchCoachForm])
                            </div>
                        </div>
                </div>
            </div>


            @foreach($viewData->availability()->hours() as $availabilityTimeHour )

                <div class="row mt-4">
                    <div class="col-12 bg-corporate-color-light text-corporate-dark-color fw-bold rounded">
                        <span class="h5 p-2 fw-bold">
                            <i class="far fa-clock"></i> <span class="d-inline-block ms-2">{{$availabilityTimeHour->timeHour()->name}}</span>
                        </span>
                    </div>
                </div>

                <div class="row">

                            @forelse ($availabilityTimeHour->coachFreeSlotsSortedTo() as $coachFreeSlots)
                                @php $coach = $coachFreeSlots->coach() @endphp
                                <div class=" col col-md-4 col-xl-3 p-3 d-flex align-items-stretch">

                                    <div class="card p-2 d-flex flex-column">

                                        <div class="row ">

                                            <div class="col-12">

                                                @if ($coach->profileImage)
                                                    <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid w-20 float-start me-3 mb-2" alt="Coach Photo">
                                                @else
                                                    <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid w-20 float-start me-3 mb-2" alt="Coach Photo">
                                                @endif

                                                <span class="d-inline-block fw-bold">
                                            {{$coachFreeSlots->coach()->writeFullName()}}
                                        </span>

                                                <p class="mb-0 mt-1">
                                                    <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
                                                         title="Flag of {{$coach->country->name}}"
                                                         class="img-thumbnail flag-icon-25 me-20"/>

                                                    <span class="d-inline-block">
                                                {{$coach->country->name}}
                                            </span>
                                                </p>
                                                <div class="mt-1">

                                                    @php $reviewsStats = $viewData->reviewsStatsCollection()->getByCoach($coach)->reviewsStats() @endphp
                                                    @if ($reviewsStats)
                                                        <div class="small">
                                                            @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                                                            <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <span class="fw-bold text-corporate-color">Le gusta</span>

                                                {{ $coach->hobby->implode(function ($hobby){
                                                        return $hobby->description;
                                                }, ', ')   }}
                                            </div>

                                        </div>

                                        <div class="row mt-auto">
                                            <div class="col-12 text-center ">

                                                {{ Form::model($showCoachForm->model(),  [
                                                  'class' => '',
                                                  'url'=> $showCoachForm->buildAction()->get(),
                                                  'autocomplete' => 'off',
                                                  'id' =>'show-coach-form'])
                                            }}

                                                @foreach ($showCoachForm->model() as $field=>$value)
                                                    <input type="hidden" name="{{$field}}" value="{{$value}}"/>
                                                @endforeach

                                                <input type="hidden" name="coach_id" value="{{ $coach->hashId() }}"/>
                                                <input type="hidden" name="time_hour_id" value="{{$availabilityTimeHour->timeHour()->id}}"/>

                                                <button class="btn bg-corporate-color text-white btn-sm btn-bold px-4" type="submit">
                                                    View
                                                </button>

                                                {{Form::close()}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty

                                <div class="col-12 col-md-4 mt-2">
                                    <span class="text-warning-dark fw-bold"><i class="fa fa-exclamation-circle"></i> We apologize, there are no coaches during this time.</span>
                                </div>
                            @endforelse
                        </div>



            @endforeach
        </div>
    </div>
@endsection
