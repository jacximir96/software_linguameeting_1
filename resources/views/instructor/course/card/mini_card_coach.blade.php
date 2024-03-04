<div class="card h-100">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <a href="{{route('get.admin.coach.show', $coach->id)}}" class="mr-2" target="_blank" title="Show coach">
            {{$coach->writeFullName()}}
        </a>
    </div>
    <div class="card-body padding-05-rem">
        <div class="row">
            <div class="col-3">
                <i class="fa fa-user fa-3x"></i>
            </div>
            <div class="col-9">

                <div class="">
                    <p class="mb-0">
                        <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
                             title="Flag of {{$coach->country->name}}"
                             class="img-thumbnail flag-icon-25 me-20" />
                        {{$coach->country->name}}
                    </p>
                    <p class="mb-0">
                        <i class="fa fa-star small rating-color"></i>
                        <i class="fa fa-star small rating-color"></i>
                        <i class="fa fa-star small rating-color"></i>
                        <i class="fa fa-star small rating-color"></i>
                        <i class="fa fa-star small "></i>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="small text-muted mb-0">
                    @if ($coach->hobby->count())
                        <span class="text-corporate-dark-color fw-bold">Le gusta</span> {{$coach->hobby->implode(function ($hobby){return $hobby->description;},', ')}}
                    @else
                        <span class="subtitle-color">Without Hobbies</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center d-flex justify-content-between">
                <a href="#"
                   class="d-block text-corporate-dark-color small"
                   data-bs-toggle="modal"
                   data-bs-target="#modal-coach-{{$coach->hashId()}}">
                    View More
                </a>

                <a href="{{route('get.common.coaches.evaluation_manager.show', $coach->hashId())}}"
                   class="open-modal {{$coach->evaluationManager->count() ? 'text-primary' : 'text-muted'}} d-block text-corporate-dark-color small"
                   data-modal-reload="no"
                   data-modal-title='Show Evaluation Manager'
                   title="{{$coach->evaluationManager->count() ? 'Show feedback' : 'This coach has not evaluation'}}">
                    View Linguameeting Feedback
                </a>
            </div>
        </div>
    </div>
</div>

@include('common.modal_info', [
           'modalId' => 'modal-coach-'.$coach->hashId(),
           'modalTitle' => 'Coach '.$coach->writeFullNameAndLastname(),
           'size' => 'modal-md',
           'path' => 'student.enrollment.session.modal_info_coach',
           'coach' => $coach,
           'reviewsStats' => $reviewsStatsCollection->getByCoach($coach)->reviewsStats(),
       ])



