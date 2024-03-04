<div class="stepwizard mt-4">
    <div class="stepwizard-row setup-panel d-none d-sm-table-row">
        <div class="stepwizard-step">

            @if ($step > 1 )
                @if (isset($course))
                    <a href="{{route('get.admin.course.coaching_form_experiences.create.update.academic_dates', $course)}}"
                       title="Go to school information step"
                        class="btn  bg-corporate-color text-white fw-bold btn-circle" disabled="disabled">01</a>
                @else

                    <a href="{{route('get.admin.course.coaching_form_experiences.create.academic_dates')}}"
                       title="Go to school information step"
                        class="btn  bg-corporate-color text-white fw-bold btn-circle" disabled="disabled">01</a>

                @endif
            @else
                <a href="#step-1"  class="btn  {{$step > 1 ? 'bg-corporate-color text-white fw-bold' : 'btn-secondary'}}  btn-circle" disabled="disabled">01</a>
            @endif

            <span class="{{ ($step == 1) ? 'fw-bold text-decoration-underline' : ''}} {{$step > 1 ? 'text-corporate-color' : 'text-dark'}}">Academic Dates</span>
        </div>


        <div class="stepwizard-step">
            @if ($step > 2 )
                <a href="{{route('get.admin.course.coaching_form_experiences.section_information', $course)}}"
                   title="Go to select weeks step"
                    class="btn  bg-corporate-color text-white fw-bold btn-circle" disabled="disabled">02</a>
            @else
                <a href="#step-2"  class="btn  {{$step > 2 ? 'bg-corporate-color text-white fw-bold' : 'btn-secondary'}}  btn-circle" disabled="disabled">02</a>
            @endif

            <span class="{{ ($step == 2) ? 'fw-bold text-decoration-underline' : ''}} {{$step > 2 ? 'text-corporate-color' : 'text-dark'}} ">Section Information</span>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3"  class="btn   {{$step > 3 ? 'bg-corporate-color text-white fw-bold' : 'btn-secondary'}}   btn-circle" disabled="disabled">03</a>
            <span class="{{ ($step == 3) ? 'fw-bold text-decoration-underline' : ''}} {{$step > 3 ? 'text-corporate-color' : 'text-dark'}} ">Course Summary</span>
        </div>
    </div>
    <div class="stepwizard-row setup-panel d-table-row d-sm-none">
        <div class="stepwizard-step">
            <a href="#step-{{$step}}"  class="btn bg-corporate-color text-white fw-bold btn-circle" style="width: 50px">0{{$step}} / 05</a>
            <span class="text-corporate-color">
                @if ($step == 1)
                    Academic Dates
                @elseif ($step == 2)
                    Sections Information
                @elseif ($step == 5)
                    Course Summary
                @endif
            </span>
        </div>
    </div>
</div>
