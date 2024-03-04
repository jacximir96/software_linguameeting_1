@extends('layouts.app')

@section('content')

<div class="row margin-top-20">

    <div class="col-md-12">

        <div class="card chart-card-background">

            <div class="card-body float-none">

                <div class="">
                    <div class="title-dashboard-circle float-start">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" fill="white" viewBox="0 0 384 512">
                            <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                    </div>

                    <div class="title-dashboard">

                        <strong>Average feedback according to Rubric</strong>
                        <a  href=""
                            class="text-corporate-color"
                            data-bs-toggle="modal"
                            data-bs-target="#info-rubric"
                            title="Read Rubric">
                            (LinguaMeeting Rubric)
                        </a>

                        @include('common.modal_info', [
                                    'rubric' => $viewData->rubric(),
                                    'size' => 'modal-lg',
                                   'modalId' => 'info-rubric',
                                   'modalTitle' => "Rubric for Student's Participation",
                                   'path' => 'instructor.course.gradebook.rubric'
                               ])
                    </div>
                </div>

                <div class="chartRegisteredStudents float-none mt-4">
                    <canvas id="gradebook-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6">
        <a class="a-title">
            <div class="float-start me-4">
                Student Activity
            </div>
            <div class="float-start me-1">
                <span>
                    <div class="text-corporate-color me-1 cursor_pointer" href="#" data-toggle="modal" data-target="#gradebook">
                        <u>Download Gradebook</u>
                    </div>
                </span>

            </div>
            <div class="float-start">
                <span class="text-corporate-color"><i class="fas fa-location-arrow"></i></span>
            </div>
        </a>
    </div>
</div>

<div class="row mt-2">
    <div class="col-xl-6"></div>
    <div class="col-xl-3">
        <select id="courses-ids" class="" multiple>

            @foreach ($viewData->courses() as $course)
                <option value="course-{{$course->hashId()}}" class="fw-bold">{{$course->name}}</option>

                @foreach ($viewData->sectionsSorted($course) as $section)
                    <option value="section-{{$section->hashId()}}" class="ps-3">{{$section->name}}</option>
                @endforeach
            @endforeach
        </select>
    </div>

    <div class="col-xl-3">
        <input type="text" name="daterange" id="daterange" class="form-control" value="" placeholder="Select date range" />
    </div>
</div>


<div class="card float-none margin-top-10">
    <div class="card-body card-list-students">
        @include('instructor.course.gradebook.students_table', [
            'students' => $viewData->students()->get(),
            'maxSessions' => $viewData->numMaxOfSessions()])
    </div>
</div>

@include('instructor.course.gradebook.modal_download')

<script>

    $(document).ready(function () {

        jQuery.ajaxSetup({cache: false});



        function search (coursesSelected, dateFrom, dateTo){

            var url = "{{route('post.instructor.api.students.filter.by_course.print_html')}}";

            // Realiza la solicitud AJAX
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    'instructor_id': "{{$instructor->hashId()}}",
                    'course_selected': coursesSelected,
                    'date_from' : dateFrom,
                    'date_to' : dateTo,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    jQuery('.card-list-students').html(data);
                },
                error: function (error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }


        $("#courses-ids").selectize({
            plugins: ["restore_on_backspace", "clear_button", "remove_button"],
            placeholder: 'All Courses',
            persist: false,

            onChange: function(value, isOnInitialize) {

                var daterangeValue = $('#daterange').val()

                search(value, daterangeValue, null)
            }
        });


        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
        }, function(start, end, label) {

            search($('#courses-ids').val(), start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))

        });

        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');

            search($('#courses-ids').val(), '', '')
        });



        gradeBookChart = function () {

            if ($('#gradebook-chart').length > 0) {
                //var data = jQuery.parseJSON(result);
                var ctx2 = $('#gradebook-chart');
                var myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        /*labels: ["0", "3", "4", "5", "6", "7", "8", "9"],*/
                        labels: {{$viewData->gradeStats()->printLabelsToJson()}},
                        datasets: [{
                            label: '',
                            data: {{$viewData->gradeStats()->printCountToJson()}},
                            /*data: [27, 51, 32, 87, 120, 41, 223, 314],*/

                            backgroundColor: [
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                            ],
                            borderColor: [
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',
                                'rgba(217, 217, 217, 1)',

                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }

                    }
                });
            }
        };

    });


</script>

@endsection
