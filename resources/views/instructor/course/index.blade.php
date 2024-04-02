@extends('layouts.app')

@section('content')

@if ( count($data->courses())>0)

<div class="row">
    <div class="text-left">
        @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div id="errorMessage" class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <span class="text-corporate-dark-color box_sessions_tag"><strong>Active Courses </strong></span>
    </div>
    
    <div class="col-md-6">

        <a href="{{route('get.instructor.course.active.index')}}">
        <div class="text-corporate-dark-color text-right cursor_pointer">
            <strong>See section list</strong>
        </div>
        </a>
        
    </div>

</div>
@endif

<div class="row">
    
    @php($count = 1)
    @forelse ($courses as $course)  

    
    <div class="col-md-3">
        
        <div class="card card-course-dashboard background-color-card{{$count}}">

            <div class="card-body float-none">

                <div class="float-end">

                    <div class="cursor_pointer" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/></svg>
                    </div>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1" >

                    <a class="dropdown-item cursor_pointer" href="{{route('get.instructor.course.show', $course->id)}}">See course Instructionss</a>

                    <a class="dropdown-item cursor_pointer" href="{{route('get.common.course.section.file.instructions.download', $course->id)}}">
                        Download Instructions
                    </a>
                    <a class="dropdown-item cursor_pointer">
                        Add Conversation Guides
                    </a>
                    <div class="dropdown-item cursor_pointer">Add make-up session to all</div>
                    <div class="dropdown-item cursor_pointer">Download attendance report</div>

                    <a href="{{route('get.admin.course.coaching_form.update.course_information', $course->id)}}" class="dropdown-item cursor_pointer">Edit Coaching Form</a>
                        <div class="dropdown-item cursor_pointer close-course-btn" data-id="{{$course->id}}" data-Code={{$course->code}}>Close course</div>
                        <div class="dropdown-item cursor_pointer duplicate-course-btn"  data-Duplicate={{$course->id}}>Duplicate Coaching Form</div>      
                    </div>

                </div>
                <br/>
                <a class="icon-card-dashboard float-none" href="{{route('get.instructor.course.show', $course->id)}}">

                    @if ($count==1)
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M297.2 248.9C311.6 228.3 320 203.2 320 176c0-70.7-57.3-128-128-128S64 105.3 64 176c0 27.2 8.4 52.3 22.8 72.9c3.7 5.3 8.1 11.3 12.8 17.7l0 0c12.9 17.7 28.3 38.9 39.8 59.8c10.4 19 15.7 38.8 18.3 57.5H109c-2.2-12-5.9-23.7-11.8-34.5c-9.9-18-22.2-34.9-34.5-51.8l0 0 0 0c-5.2-7.1-10.4-14.2-15.4-21.4C27.6 247.9 16 213.3 16 176C16 78.8 94.8 0 192 0s176 78.8 176 176c0 37.3-11.6 71.9-31.4 100.3c-5 7.2-10.2 14.3-15.4 21.4l0 0 0 0c-12.3 16.8-24.6 33.7-34.5 51.8c-5.9 10.8-9.6 22.5-11.8 34.5H226.4c2.6-18.7 7.9-38.6 18.3-57.5c11.5-20.9 26.9-42.1 39.8-59.8l0 0 0 0 0 0c4.7-6.4 9-12.4 12.7-17.7zM192 128c-26.5 0-48 21.5-48 48c0 8.8-7.2 16-16 16s-16-7.2-16-16c0-44.2 35.8-80 80-80c8.8 0 16 7.2 16 16s-7.2 16-16 16zm0 384c-44.2 0-80-35.8-80-80V416H272v16c0 44.2-35.8 80-80 80z"/></svg>     
                
                    @elseif ($count==2)
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
                
                    @elseif ($count==3)
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 0C139 0 96 43 96 96V256c0 53 43 96 96 96s96-43 96-96V96c0-53-43-96-96-96zM64 216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 89.1 66.2 162.7 152 174.4V464H120c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H216V430.4c85.8-11.7 152-85.3 152-174.4V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 70.7-57.3 128-128 128s-128-57.3-128-128V216z"/></svg>
                
                    @elseif ($count==4)
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M190.4 74.1c5.6-16.8-3.5-34.9-20.2-40.5s-34.9 3.5-40.5 20.2l-128 384c-5.6 16.8 3.5 34.9 20.2 40.5s34.9-3.5 40.5-20.2l128-384zm70.9-41.7c-17.4-2.9-33.9 8.9-36.8 26.3l-64 384c-2.9 17.4 8.9 33.9 26.3 36.8s33.9-8.9 36.8-26.3l64-384c2.9-17.4-8.9-33.9-26.3-36.8zM352 32c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32z"/></svg>
                
                    @endif

                    </a>
                <a class="a-title" href="{{route('get.instructor.course.show', $course->id)}}">
                    <div class="small-font-size margin-top-20" >
                        <strong>{{$course->name}}</strong>
                    </div>
                </a>
                <a class="a-title" href="{{route('get.instructor.course.show', $course->id)}}">
                <div class="small-font-size-08 margin-top-10">{{$course->start_date->format('d F')}} - {{$course->end_date->format('d F')}}</div>
                </a>
                
                <a class="a-title" href="{{route('get.instructor.course.show', $course->id)}}">
                <div class="card-sep-course-dashboard cursor_pointer">

                    <div class="float-start">
                        Registered Students
                    </div>

                    <div class="float-end">
                        <strong>{{$course->enrollment_count}}</strong>
                    </div>

                </div>
                    </a>

            </div>
            
        </div>
        
    </div>

    
    
    @php($count = $count + 1)
    @if ($count==4)
    @php($count = 1)
    @endif

    @empty
<div class="row mt-4">

    <div class="col-md-12">
        <div class="text-center">
            <a href="{{route('get.instructor.coaching_form.zero_step')}}" class="bg-text-corporate-color colorWhite create-course-btn">
                <i class="fas fa-plus"></i>
                Create course
            </a>
        </div>
        
    </div>

</div>

@endforelse


</div>

@if ( count($data->courses())>0)

<div class="modal fade bd-example-modal-lg" id="modalDuplicateCourse" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-content">
            <form action="{{route('get.admin.course.coaching_form.create.duplicate.course_information', $course->id)}}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-tittle" style="color:white;"><span class="title-form">DUPLICATE COURSE</span></h4>
                </div>
                <input type="text" name="idDuplicate" id="idDuplicate" hidden>
                <div class="modal-body" id="modal-container">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="term_activeCourse">Term</label>
                                <select class="form-control" name="term_activeCourse" id="term_activeCourse"
                                style="text-transform: uppercase;" required>
                                    <option value="" selected disabled>Select semester</option>
                                    @foreach($semesters as $semester)
                                    <option value="{{$semester->id}}">{{$semester->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label for="year_activeCourse">Year</label>
                                <select class="form-control" name="year_activeCourse" id="year_activeCourse"
                                style="text-transform: uppercase;" required>
                                    <option value="" selected disabled>Select year</option>
                                    @foreach($arrayYears as $arrayYear)
                                    <option value="{{$arrayYear}}">{{$arrayYear}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="startDate_activeCourse">Academic Course Start Date</label>
                                <input type="date" class="form-control" name="startDate_activeCourse" id="startDate_activeCourse"
                                style="text-transform: uppercase;" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="endDate_activeCourse">Academic Course End Date</label>
                                <input type="date" class="form-control" name="endDate_activeCourse" id="endDate_activeCourse"
                                style="text-transform: uppercase;" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex">
                    <div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancelDuplicate">
                            <i class="fa fa-undo" style="font-size:15px;"></i>&nbsp;&nbsp;&nbsp;Cancel
                        </button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save" style="font-size:15px;"></i>&nbsp;&nbsp;&nbsp;Duplicate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="modal fade bd-example-modal-lg" id="modalCloseCourse" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-content">
                <form method="POST" action="{{route('post.admin.course.coaching_form.close.course', 1)}}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="idSection" id="idSection" hidden>
                <input type="text" name="idCode" id="idCode" hidden>
                    <div class="modal-body">
                        <h4 class="modal-tittle" style="color:white;"><span class="title-form">CLOSE COURSE</span></h4>
                        <p>Now that your course has ended, it will be moved to Past Courses.</p>
                    </div>

                    <div style="padding: 0px 15px 10px 15px; display: flex; justify-content: space-between;">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
                        <button type="submit" class="btn btn-sm bg-text-corporate-color" style="color:white">OK</button>  
                    </div>
                </form>
            </div>
        </div>
    </div>

@endif

<script>
    setTimeout(function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 3000);
    setTimeout(function() {
        var errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 3000);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var closeCourseBtns = document.querySelectorAll(".close-course-btn");
        closeCourseBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var courseId = btn.getAttribute("data-id");
                document.getElementById("idSection").value = courseId;

                var courseCode = btn.getAttribute("data-Code");
                document.getElementById("idCode").value = courseCode;
                $('#modalCloseCourse').modal('show');
            });
        });
        var duplicateCourseBtns = document.querySelectorAll(".duplicate-course-btn");
        duplicateCourseBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var duplicateId = btn.getAttribute("data-Duplicate");
                document.getElementById("idDuplicate").value = duplicateId;
                $('#modalDuplicateCourse').modal('show');
            });
        });
    });
    
</script>


@endsection
