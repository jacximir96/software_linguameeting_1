<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-chalkboard-teacher me-1"></i>
                    Instructor details
                </span>
    </div>
    <div class="card-body">

        <div class="row gx-3 mb-4">

            <div class="col-md-6">
                @include('common.card_field', ['tag' => 'Fullname', 'value' => $instructor->writeFullName(), 'valueIsBold' => true])
            </div>

            <div class="col-md-6">
                @include('common.card_field', ['tag' => 'Email', 'value' => $instructor->email])
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-6">
                @include('common.card_field', ['tag' => 'Country', 'value' => $instructor->country->name])
            </div>

            <div class="col-md-6">
                @include('common.card_field', ['tag' => 'Timezone', 'value' => $instructor->timezone->name])
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-6">
                @include('common.card_field', ['tag' => 'Languages', 'value' => $instructor->language->pluck('name')->implode(', ')])
            </div>

            <div class="col-md-6">

                <div class="row">
                    <div class="col-12">
                        <label class="me-3 fw-bold text-corporate-color">Role</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="{{$colorFactory->classColorByInstructorRol($instructor->rol())}}">
                                {{$instructor->getRoleNames()->first()}}
                            </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-12">

                <div class="row">
                    <div class="col-12">
                        <label class="me-3 fw-bold text-corporate-color">Universities</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @forelse ($instructor->university as $university)
                            <a href="{{route('get.admin.university.show', $university->hashId())}}" class="mr-2" title="Show university">
                                {{$university->name}}
                            </a>
                        @empty
                            <span class="fst-italic">The instructor is not associated with any university</span>
                        @endforelse
                    </div>
                </div>
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
                        {{$instructor->active ? 'Yes' : 'No'}}
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
                        @if($instructor->hasEmailVerified())
                            <span class="small">
                                At {!! toDatetimeInOneRow($instructor->email_verified_at, $timezone->name, true)!!}
                            </span>
                        @else
                            No
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-12">
                @include('common.card_field', ['tag' => 'Comment', 'value' => $instructor->hasInternalComment() ? $instructor->internal_comment : '-'])
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-6">
                <label class="small mb-1 d-block fw-bold "></label>
                <a href="{{route('get.admin.instructor.edit', $instructor->hashId())}}" class="text-primary me-3"><i class="fa fa-edit"></i> Edit</a>

                <a  href="{{route('get.impersonate.start',$instructor->hashId())}}"
                    class="me-3"
                    title="Access as {{$instructor->name}}">
                    <i class="fa fa-user-friends"></i> Simulation as {{$instructor->name}}
                </a>

            </div>
        </div>

    </div>
</div>
