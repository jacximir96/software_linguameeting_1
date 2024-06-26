
@extends('layouts.app')
@include('common.activeStyle')
@section('content')
<div class="row">
    <div class="col-md-12">
        <span class="text-corporate-dark-color box_sessions_tag"><strong>Active Courses </strong></span>
    </div>
</div>

<div class="row margin-top-20">

    

    <div class="col-md-12">
        <button onclick="exportTableToExcel()">Exportar a Excel</button>
        <a href="{{route('get.instructor.course.index')}}">
        <div class="text-corporate-dark-color text-right cursor_pointer">
            <strong>See course view</strong>
        </div>
        </a>

    </div>

</div>

<div class="row margin-top-10">
    <div class="col-md-12">
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
    </div>
</div>

<div class="card float-none margin-top-10 card-list-courses-instructor">

    <div class="card-body">
        

        <table id="table-instructor" class="table">
            <thead>
                <tr>
                    
                    {{-- <th class="">SESSIONS</th> --}}
                    <th class="">COURSE NAME</th>
                    {{-- <th>SECTION</th> --}}
                    <th>COACHING PERIOD</th>
                    <th class="">CREATED</th>
                    <th>REGISTERED STUDENTS</th>
                    <th>CLASS ID/INSTRUCTIONS</th>
                    <th>INSTRUCTOR</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                
                @forelse ($sections as $section)
                @if ($section->course->isActive())
                <tr style="vertical-align: middle;">
                    
                    {{-- <td><u>1</u></td> --}}
                    <td class="cursor_pointer">
                        <a class="a-title" href="{{route('get.instructor.course.show', $section->course_id)}}" title="Show course"><u> {{$section->course->name}}</u></a>
                    </td>
                    {{-- <td>
                        <u style="text-decoration:none;">{{$section->name}}</u>
                    </td> --}}

                    @if($section->course->isFlex())
                    <td>{{$section->course->firstDate()->format('m/d/y')}} - {{$section->course->lastDate()->format('m/d/y')}}  </td>
                    @else

                        @if($section->course->hasCoachingWeek())
                        <td>{{$section->course->firstDate()->format('m/d/y')}} - {{$section->course->lastDate()->format('m/d/y')}}  </td>
                        @else
                        <td>MM/DD/YY - MM/DD/YY</td>
                        @endif
                    @endif

                    <td>
                        <u style="text-decoration:none;"><strong>{{$section->course->created_at->format('M d, y')}}</strong></u>
                    </td>

                    <td>{{$section->enrollment()->count()}}/{{$section->num_students}}</td>
                    
                    <td>
                        <a class="a-title" href="{{route('get.common.course.section.file.instructions.download', $section->id)}}"><u>{{$section->code}}</u></a>
                    </td>
                    <td>{{$section->instructor->writeFullName()}}</td>
                    <td>
                        <div class="custom-select">
                            <div class="select-selected">Seleccionar una opción</div>
                            <div class="select-items">
                                <div><a href="{{route('get.instructor.course.show', [$section->course_id])}}" style="text-decoration: none; color:black">&nbsp;&nbsp;See course Instructions</a></div>
                                <div><a href="{{route('get.common.course.section.file.instructions.download', $section->id)}}" style="text-decoration: none; color:black">&nbsp;&nbsp;Download Instructions</a></div>
                                <div><a href="{{route('get.instructor.course.show', [$section->course_id, $section->id])}}" style="text-decoration: none; color:black">&nbsp;&nbsp;Add Conversation Guides</a></div>
                                <div><a href="{{route('get.instructor.course.makeup.assign', $section->course_id)}}"
                                    title="Add make-up all students"
                                    class="open-modal text-dark"
                                    data-modal-size="modal-md"
                                    data-modal-reload="yes"
                                    data-reload-type="parent"
                                    data-modal-title="Add Make-up" style="text-decoration: none; color:black">&nbsp;&nbsp;Add make-up session to all</a>
                                </div>
                                <div>&nbsp;&nbsp;Download attendance report</div>
                                <div><a href="{{route('get.admin.course.coaching_form.update.course_information', $section->course->id)}}" style="text-decoration: none; color:black">&nbsp;&nbsp;Edit Coaching Form</a></div>
                                <div class="close-course-btn" data-idSection={{$section->course_id}} data-idCode={{$section->code}}>&nbsp;&nbsp;Close course</div>
                                <div class="duplicate-course-btn" data-idDuplicate={{$section->course_id}}>&nbsp;&nbsp;Duplicate Coaching Form</div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                    <tr>
                        <td>
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No sections</span>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

</div>


<div class="modal fade bd-example-modal-lg" id="modalMakeup" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-content">
            <form action="{{route('get.admin.course.coaching_form.update.course_information', 2650)}}" method="POST">
                @csrf
                <div class="modal-header  bg-text-corporate-color text-white">
                    <h5 class="modal-title">Add Make-up</h5>
                </div>
                <div class="modal-body" style="margin-left: 10px; margin-right: 10px">
                    <div class="row mt-2">
                        <div class="col-12">
                            Add purchase make-up to course: <span class="fw-bold fst-italic font-primary">aqui va el course name</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 ">
                            @include('common.form-field.number', ['field' => 'number_makeups', 'label' => 'Make-ups Numbers', 'min' => 1, 'step' => 1, 'required' => true])
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                Save
                            </button>
                        </div>
                    </div>
                </div>    
            </form>
        </div>
    </div>
</div>



<div class="modal fade bd-example-modal-lg" id="modalDuplicateCourse" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-content">
            <form action="{{route('get.admin.course.coaching_form.create.duplicate.course_information', 1)}}" id="formDuplicateCourse">
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
            <form method="POST" id="formCloseCourse" action="{{route('post.admin.course.coaching_form.close.course', 1)}}">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var closeCourseBtns = document.querySelectorAll(".close-course-btn");
        closeCourseBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var courseId = btn.getAttribute("data-idSection");
                document.getElementById("idSection").value = courseId;

                var courseCode = btn.getAttribute("data-idCode");
                document.getElementById("idCode").value = courseCode;
                $('#modalCloseCourse').modal('show');
            });
        });
        var duplicateCourseBtns = document.querySelectorAll(".duplicate-course-btn");
        duplicateCourseBtns.forEach(function(btn) { 
            btn.addEventListener("click", function() {
                var duplicateId = btn.getAttribute("data-idDuplicate");
                document.getElementById("idDuplicate").value = duplicateId;
                $('#modalDuplicateCourse').modal('show');
            });
        });
    });
    
</script>


<script>
    document.addEventListener("click", function(e) {
      var customSelects = document.getElementsByClassName("custom-select");
      for (var i = 0; i < customSelects.length; i++) {
        var select = customSelects[i].getElementsByTagName("div");
        if (e.target == select[0]) {
          select[1].classList.toggle("show");
        } else if (!customSelects[i].contains(e.target)) {
          select[1].classList.remove("show");
        }
      }
    });
    
    var options = document.querySelectorAll(".custom-select .select-items div");
    options.forEach(function(option) {
      option.addEventListener("click", function() {
        var text = this.innerText;
        var parent = this.parentElement.parentElement;
        parent.getElementsByClassName("select-selected")[0].innerText = text;
        parent.getElementsByClassName("select-items")[0].classList.remove("show");
        parent.querySelector('.selected').classList.remove('selected');
        this.classList.add('selected');
      });
    });
    
</script>

<script>
    $(document).ready(function() {
        $('#table-instructor').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("cancelButton").addEventListener("click", function() {
            var selects = document.querySelectorAll('.form-select');
            selects.forEach(function(select) {
                select.value = '';
            });
        });
        document.getElementById("cancelDuplicate").addEventListener("click", function() {
            var selects = document.querySelectorAll('.form-select');
            selects.forEach(function(select) {
                select.value = '';
            });
        });
    });
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
    function exportTableToExcel() {
    var table = document.getElementById("table-instructor");
    var workbook = XLSX.utils.table_to_book(table, {sheet:"Sheet JS"});
    XLSX.writeFile(workbook, "ExportacionTabla.xlsx");
}
</script>

@endsection
