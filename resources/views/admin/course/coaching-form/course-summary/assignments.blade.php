<div class="container">
    @foreach ($section->assignments() as $assignment)

        <div class="row card mb-5 shadow-info-assignment" style="border:1px solid #aaa;">

            <div class="col-12">

                <div class="row text-corporate-dark-color fw-bold p-1">
                    <div class="col-12 col-lg-4 mt-2">
                        @if ($assignment->isWeek())
                            <span class="fw-bold">Session {{$assignment->week->session_order}}</span>
                        @else
                            <span class="fw-bold">Session {{$assignment->session_order}}</span>
                        @endif
                    </div>
                    <div class="col-12 col-lg-4 mt-2">
                        @if ($assignment->chapter)
                            <span class="subtitle-color">
                                {{$assignment->chapter->chapter->name}}
                            </span>
                        @else
                            <span class="text-corporate-danger ">No guide selected</span>
                        @endif
                    </div>
                    <div class="col-12 col-lg-4 mt-2">

                        @if ($assignment->file)

                            <a href="{{route('get.common.course.assignment.file.download', $assignment->file->id)}}"
                               title="Download file"
                               class="">
                                <i class="fa fa-download"></i> {{$assignment->file->original_name}}</a>
                        @else
                            <span class="text-corporate-danger">No file</span>
                        @endif
                    </div>
                </div>


                <div class="row mt-2 p-1 ">

                    <div class="col-12  ">
                        <span class="d-block mb-1 subtitle-color  fw-bold ">Activity Name</span>
                        <p class="border p-2  text-muted ">{!! $assignment->activity_name ?? '-' !!}</p>
                    </div>
                    <div class="col-12 ">
                        <span class="d-block mb-1 subtitle-color fw-bold">Content</span>
                        <p class="border p-2 text-muted long-text">{{ $assignment->activity_description ?? '-' }}</p>
                    </div>
                    <div class="col-12  ">
                        <span class="d-block mb-1 subtitle-color   fw-bold">Coach Note</span>
                        <p class="border p-2  text-muted long-text">{{ $assignment->coach_note ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
</div>
