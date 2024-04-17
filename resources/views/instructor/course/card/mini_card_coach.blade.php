<div>
    <div class="card-body padding-05-rem">
        <div class="row">
            <div class="card" style="box-shadow: 5px 5px 0px 1px #F0F0F0; border-radius: 0px !important; margin-top: 15px">
                <div class="card-body float-none text-center">
                    <div class="row margin-top10">
                        <div class="col-md-6 cursor_pointer text-corporate-dark-color" data-toggle="modal" data-target="#feedbackLingua{{$coach->id}}">
                            <strong>
                            <a href="{{route('get.common.coaches.evaluation_manager.show', $coach->hashId())}}"
                                class="open-modal {{$coach->evaluationManager->count() ? 'text-primary' : 'text-muted'}} d-block text-corporate-dark-color"
                                data-modal-reload="no"
                                data-modal-title='Show Evaluation Manager'
                                title="{{$coach->evaluationManager->count() ? 'Show feedback' : 'This coach has not evaluation'}}" style="font-size: 12px">
                                 View Linguameeting Feedback
                             </a>
                            </strong>
                        </div>

                        <div class="col-md-6 cursor_pointer text-corporate-color text-center" data-toggle="modal" data-target="#feedbackInst{{$coach->id}}" style="font-size: 12px">
                            <strong>Instructor's Feedback</strong>
                        </div>
                    </div>

                    <div class="margin-top-10 text-14">
                        Name: <span class="text-16"><strong>{{$coach->writeFullName()}}</strong></span>
                    </div>
                    
                    <div class="margin-top-4 text-14">
                        Country: <span class="text-16"><strong>{{$coach->country->name}}</strong></span>
                    </div>

                    <div class="margin-top-10">
                        <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}" class="flag_coach_attendance" style="height: 20px;"/>
                    </div>

                    <div class="margin-top-10 cursor_pointer text-corporate-color text-14" data-toggle="modal" data-target="#modal{{$coach->id}}">
                        <b>View More</b>
                    </div>

                    <div class="mean_stars margin-top10 margin-auto" data-rate-value="4.8">
                    </div>
                    @if (isset($coach->profileImage))
                        <div class="margin-top-10">
                            <img src="{{ asset(trim($coach->profileImage->url()->get(), '/')) }}" class="img_coach_attendance" style="height: 60px;"/>
                        </div>
                    @else
                        <div class="margin-top-10">
                            {{-- <i class="fa fa-user fa-3x"></i> --}}
                            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img_coach_attendance" alt="Coach Photo" style="height: 60px;">
                        </div>
                    @endif     
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal{{$coach->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-corporate-color text-white">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">


                    @if (isset($coach->profileImage))
                        <div class="margin-top-20">
                            <img src="{{ asset(trim($coach->profileImage->url()->get(), '/')) }}" class="img_coach_attendance"/>
                        </div>
                    @else
                        <div class="margin-top-20">
                            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img_coach_attendance" alt="Coach Photo">
                        </div>  
                    @endif 


                    <div class="text-corporate-dark-color text-20 mt-2 mb-2 ">
                        <b>{{$coach->writeFullName()}}</b>
                    </div>

                    @if ($coach->coachInfo->hasUrlVideo())
                        <div class="col-md-12 margin-top-10">
                            <a href="{{$coach->coachInfo->urlVideo()->get()}}"
                                target="_blank"
                                class="border border-2 p-1 border-color-corporate-dark text-corporate-dark-color"
                                title="See coach video">
                                 <i class="fa fa-play mx-2"></i> See coach video
                             </a>
                        </div>
                    @endif


                    <div class="nombre-coach text-20 mt-2 mb-2">
                        <b>DESCRIPTION</b>
                    </div>

                    <div class="descripcion_coach">
                        <p>
                            {{$coach->coachInfo->description}}
                        </p>
                    </div>
                </div>
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



