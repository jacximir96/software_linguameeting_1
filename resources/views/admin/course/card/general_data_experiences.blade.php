<div class="card mb-4">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-headphones me-1"></i>
            Course details
        </span>
    </div>
    <div class="card-body">

        <div class="row gx-3 mb-4">

            <div class="col-md-6 col-xl-6">
                @include('common.card_field', ['tag' => 'Name', 'value' => $course->name, 'valueIsBold' => true])
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="row">
                    <div class="col-12">
                        <label class="me-3 fw-bold text-corporate-color">University</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('get.admin.university.show', $course->university->id)}}" title="Show University">
                            {{$course->university->name}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">

                @include('common.card_field_tag', ['tag' => 'Course Coordinator'])
                <div class="row">
                    <div class="col-12">
                        @if ($course->coordinator->count())
                            <span class="{{isset($valueIsBold) ? 'fw-bold' : ''}}">
                                <a href="#">{{$course->coordinator->first()->person->writeFullName()}}</a>
                            </span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3">

            <div class="col-md-6 col-xl-2">
                @include('common.card_field', ['tag' => 'Language', 'value' => $course->language->name])
            </div>

            <div class="col-md-6 col-xl-4">
                @include('common.card_field', ['tag' => 'Service', 'value' => $course->serviceType->name])
            </div>

            <div class="col-md-6 col-xl-4">
                @include('common.card_field', ['tag' => 'Experience Type', 'value' => $course->experienceType->write()])
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Year', 'value' => $course->year])
            </div>

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Semester', 'value' => $course->semester->name])
            </div>

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Start Date', 'value' => $course->start_date->format('m/d/Y')])
            </div>

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'End Date', 'value' => $course->end_date->format('m/d/Y')])
            </div>

        </div>

        <div class="row gx-3">


            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Is Free?', 'value' => $course->isFree() ? 'Yes' : 'No'])
            </div>

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Is Lingro?', 'value' => $course->isLingro() ? 'Yes' : 'No'])
            </div>


            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Price', 'value' => $linguaMoney->format($course->experienceType->price)])
            </div>

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Discount', 'value' => $course->hasDiscount() ? $linguaMoney->format($course->discount) : 'No'])
            </div>

            <div class="col-md-6 col-lg-2">
                @include('common.card_field', ['tag' => 'Total', 'value' => $linguaMoney->format($course->price())])
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-md-6 col-lg-4">
                @include('common.card_field', ['tag' => 'Level', 'value' => $course->level->name])
            </div>

            <div class="col-md-6 col-lg-4">
                @include('common.card_field_tag', ['tag' => 'Created by'])
                <div class="row">
                    <div class="col-12">
                        <span class="{{isset($valueIsBold) ? 'fw-bold' : ''}}">
                            @if ($course->creator)
                                {{$course->creator->writeFullName()}}
                            @else
                                -
                            @endif
                        </span>
                        <span class="d-block small">
                            {{$course->created_at->format('m/d/Y H:i:s')}}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">

                @include('common.card_field_tag', ['tag' => 'Updated by'])
                <div class="row">
                    <div class="col-12">

                        @if ($course->hasAudits())
                            <span class="{{isset($valueIsBold) ? 'fw-bold' : ''}}">
                                {{$course->audits()->latest()->first()->user->writeFullName()}}
                            </span>
                            <span class="d-block small">
                                {{$course->audits()->latest()->first()->created_at->format('m/d/Y H:i:s')}}
                            </span>
                        @else
                            <span class="">
                                Without Data
                            </span>
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

       @include('admin.course.card.actions')

    </div>
</div>
