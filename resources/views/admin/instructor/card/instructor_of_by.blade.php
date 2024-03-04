<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light">
        <span class="text-corporate-dark-color fw-bold">
            @if ($instructorOf)
                <i class="fa fa-graduation-cap me-1"></i>  Instructor of
            @else
                <i class="fa fa-graduation-cap me-1"></i> Instructed by
            @endif
        </span>
    </div>
    <div class="card-body">

        <div class="row d-none d-sm-block">
            <div class="col-12">
                <table  class="table table-hover">
                    <thead>
                    <tr>
                        @if ($instructorOf)
                            <th class="w-50">Instructor assistant</th>
                        @else
                            <th class="w-50">Instructor</th>
                        @endif
                        <th>From</th>
                        @if (isset($showAction) AND ($showAction))
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($teachingAssistants as $teachingAssistant)

                        <tr>
                            <td>
                                @include('admin.instructor.card.data_instructor', [
                                   'instructorOf' => $instructorOf,
                                   'teachingAssistant' => $teachingAssistant
                                ])
                            </td>
                            <td>{{$teachingAssistant->created_at->format('m/d/Y')}}</td>
                            @if (isset($showAction) AND ($showAction))
                                <td>
                                    <a  href="{{route('get.admin.instructor.teaching_assistant.assign_instructor.delete', $teachingAssistant->hashId())}}"
                                        onclick="return confirm('Are you sure you want to delete this assignment?');"
                                        title="Remove relationship ">
                                        <i class="fa fa-times text-danger"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-block d-sm-none">

            @foreach ($teachingAssistants as $teachingAssistant)

                <div class="row">

                    <div class="col-12">
                        <span class="fw-bold d-block">
                            @if ($instructorOf)
                                Instructor assistant
                            @else
                                Instructor
                            @endif
                        </span>
                        <div class="d-block">
                            @include('admin.instructor.card.data_instructor', [
                                    'instructorOf' => $instructorOf,
                                    'teachingAssistant' => $teachingAssistant

                            ])
                            @if (isset($showAction) AND ($showAction))
                                <a  href="{{route('get.admin.instructor.teaching_assistant.assign_instructor.delete', $teachingAssistant->hashId())}}"
                                    onclick="return confirm('Are you sure you want to delete this assignment?');"
                                    title="Remove relationship ">
                                    <i class="fa fa-times text-danger"></i>
                                </a>
                            @endif
                            <span class="d-block fst-italic">
                                From {{$teachingAssistant->created_at->format('m/d/Y')}}
                            </span>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
</div>
