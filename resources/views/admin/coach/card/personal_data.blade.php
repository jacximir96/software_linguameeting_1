<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-chalkboard-teacher me-1"></i>
                    Instructor details
                </span>
    </div>
    <div class="card-body">

        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Fullname', 'value' => $coach->writeFullName(), 'valueIsBold' => true])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Coach ID', 'value' => $coach->id, 'valueIsBold' => true])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Email', 'value' => $coach->email])
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Teaching Language', 'value' => $coach->country->name ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Residence', 'value' => $coach->countryLive->name ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Timezone', 'value' => $coach->timezone->name])
            </div>
        </div>

        <div class="row gx-3 mb-4">
            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Role', 'value' => $coach->getRoleName()->first()])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Level', 'value' => $coach->coachInfo->level->name ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Languages', 'value' => $coach->language->pluck('name')->implode(', ')])
            </div>

        </div>

        <div class="row gx-3 mb-4">

            <div class="col-xl-3">

                <div class="row">
                    <div class="col-12">
                        <label class="me-3 fw-bold text-corporate-color">Active</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {{$coach->active ? 'Yes' : 'No'}}
                    </div>
                </div>
            </div>

            <div class="col-xl-6">

                <div class="row">
                    <div class="col-12">
                        <label class="me-3 fw-bold text-corporate-color">Email Verified</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if($coach->hasEmailVerified())
                            <span class="small">
                                At {!! toDatetimeInOneRow($coach->email_verified_at, $timezone->name, true)!!}
                            </span>
                        @else
                            No
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Skype', 'value' => $coach->skype ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Phone', 'value' => $coach->phone ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Phone-WhatsApp', 'value' => $coach->whatsapp ?? '-'])
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Zoom Account', 'value' => $coach->zoomUser->zoom_email ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Is Trainee?', 'value' => $coach->coachInfo->isTrainee() ? 'Yes' : 'No'])
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-12">
                @include('common.card_field', ['tag' => 'Description', 'value' => $coach->description ?? '-'])
            </div>

        </div>

        <div class="row gx-3 mb-4">

            <div class="row">
                <div class="col-12">
                    <label class="me-3 fw-bold text-corporate-color">Hoobies</label>
                </div>
            </div>
            <div class="row">

                @if ($coach->hobby->count())

                    @foreach ($coach->hobby as $hobby)
                        <div class="col-12 col-sm-6"><i class="fa fa-chevron-right small text-muted"></i> {{$hobby->description}}</div>
                    @endforeach

                @else
                    <span class="subtitle-color">Without hobbies</span>
                @endif
            </div>
        </div>

        <div class="row gx-3 mb-4">
            @include('admin.coach.card.media_field')
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-md-3">
                <a href="{{route('get.admin.coach.edit', $coach->hashId())}}" class="text-primary me-3"><i class="fa fa-edit"></i> Edit</a>
            </div>

            <div class="col-md-3">
                <a href="{{route('get.impersonate.start',$coach->hashId())}}"
                   class="me-3"
                   title="Access as {{$coach->name}}">
                    <i class="fa fa-user-friends"></i> Simulation as {{$coach->name}}
                </a>
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-md-3">
                <a href="{{route('get.admin.coach.schedule.show', $coach->hashId())}}" class="text-primary me-3"><i class="fa fa-calendar"></i> Show Schedule</a>
            </div>
            <div class="col-md-3">
                <a href="{{route('get.admin.coach.calendar.show', $coach->hashId())}}" class="text-primary me-3"><i class="fa fa-calendar"></i> Show Calendar</a>
            </div>
            <div class="col-md-3">
                <a href="{{route('get.admin.coach.billing.for_one.show', $coach->hashId())}}" class="text-primary me-3"><i class="fa fa-dollar-sign"></i> Billing</a>
            </div>
        </div>

    </div>
</div>
