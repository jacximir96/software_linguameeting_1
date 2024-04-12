@foreach ($course->obtainFlexSessions()->get() as $flexSession)

    <div class="row border-bottom shadow-sm d-flex align-items-center  py-2 bg-corporate-color-lighter-2"  name="anchor-accordion-{{$section->id}}">
        <div class="col-12 col-sm-6 col-xl-3">
            <span class="fw-bold text-corporate-color h5 d-none d-md-block  ">Session {{$loop->iteration}}</span>
            <span class="fw-bold text-corporate-color h6 d-block d-md-none mb-0 pb-0  ">Session {{$loop->iteration}}</span>
        </div>

        <div class="col-12 col-sm-6 col-xl-1 mt-2">
            <span class="subtitle-color fw-bold "></span>
        </div>

        <div class="col-12 col-sm-6 col-md-7 col-xl-5 mt-2 mb-2">
            @if ($form->hasChaptersOptions())
                <div class="d-flex align-items-center">
                    {{Form::select('chapter_id['.$flexSession->number().']', $form->chaptersOptions(), null,
                                [   'class'=>'form-input-chapter-id flex-small-group-chapter-id form-control form-select ',
                                    'style' => 'margin-right: 25px;', 
                                    'placeholder' => 'Select Conversation Guide',
                                    'data-url-update' => route('post.common.course.assignment.api.guide.update.flex.small', [$section->id, $flexSession->number()])
                                    ])}}
                    
                    <input name="chapter" type="text" hidden>
                    <a href="#" class="download-link">
                        <i class="fa fa-download"></i>
                    </a>
                </div>
            @endif
        </div>

        {{-- <input name="chapter" type="text" hidden>
        <div class="col-12 col-sm-6 col-md-7 col-xl-1 mt-2 mb-2 text-sm-end">
            <a href="#" class="download-link">
                <i class="fa fa-download"></i>
            </a>
        </div> --}}

        <div class="col-12 col-sm-6 col-md-5 col-xl-3 mt-2 mt-sm-0 p-0 text-sm-center">
            <a href="{{route('get.common.course.assignment.flex.edit',[$section->id, $flexSession->number()])}}"
               class="open-modal btn border-1 rounded small p-0"
               style="font-size: 0.875em;"
               data-modal-reload="yes"
               data-modal-size="modal-lg"
               data-reload-type="parentWithUrl"
               data-reload-url="{{url()->current()}}?sectionToExpand={{$section->id}}&time={{time()}}#anchor-accordion-{{$section->id}}"
               data-modal-title="Manage Assignments"
               title="Manage assignments">
                @if ($section->hasAssignmentsInFlex($flexSession->number()))
                    <i class="fa fa-check text-success"></i> Assignment
                @else
                    <i class="fa fa-plus"></i> Create Assignment
                @endif
            </a>
        </div>
    </div>
@endforeach

<script>
    $(document).ready(function() {
        function setInitialValues() {
            $('select.form-input-chapter-id').each(function() {
                var selectedValue = $(this).val();
                var $textInput = $(this).closest('.row').find('input[type="text"]');
                $textInput.val(selectedValue);
            });
        }
        setInitialValues();

        $('select.form-input-chapter-id').change(function() {
            var selectedValue = $(this).val();
            var $textInput = $(this).closest('.row').find('input[type="text"]');
            $textInput.val(selectedValue);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.download-link').click(function(event) {
            event.preventDefault();
            var selectedValue = $(this).closest('.row').find('input[type="text"]').val();
            var downloadUrl = "{{ route('get.common.conversation_guide.chapter.file.downloadChapter') }}?chapter=" + selectedValue;
            window.location.href = downloadUrl;
        });
    });
</script>


