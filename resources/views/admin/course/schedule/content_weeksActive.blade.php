<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Browser periods in flex course startDate to endDate</h6>
            </div>
            <div class="card-body padding-05-rem">
                <div class="row">
                    <div class="col-6 text-center">
                        <form id="backForm" method="GET" action="{{ route('get.instructor.course.show', $course->id) }}">
                            <input type="hidden" name="direction" value="back">
                            <button type="submit" class="btn btn-link">
                                <i class="fa fa-arrow-left fa-2x text-muted"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-6 text-center">
                        <form id="nextForm" method="GET" action="{{ route('get.instructor.course.show', $course->id) }}">
                            <input type="hidden" name="direction" value="next">
                            <button type="submit" class="btn btn-link">
                                <i class="fa fa-arrow-right fa-2x text-muted"></i>
                            </button>
                        </form>
                    </div>
                    
                    
                </div>
            </div>          
        </div>
    </div>
</div>

<div class="row mt-3">

    @foreach ($coachesActive as $coach)
        <div class="col-md-3 d-flex">
            <div class="card h-100">
                <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <a href="#" class="mr-2" target="_blank" title="Show coach">
                        {{$coach->name}} {{$coach->lastname}}
                    </a>
                </div>
                <div class="card-body padding-05-rem">
                    <div class="row">
                        <div class="col-3">
                            <i class="fa fa-user fa-3x"></i>
                        </div>
                        <div class="col-9">
            
                            <div class="">
                                <p class="mb-0">
                                    <img src="{{ asset('assets/img/flags/' . $coach->flag . '.png') }}"
                                        class="img-thumbnail flag-icon-25 me-20" />
                                    {{$coach->countryName}}
                                </p>
                                <p class="mb-0">
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small "></i>
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="small text-muted mb-0">
                                <span class="text-corporate-dark-color fw-bold">Le gusta</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <form method="GET" class="courseActive_id" action="{{route('get.instructor.course.show', $course->id)}}">
                        <input type="hidden" name="coach_id" value="{{$coach->id}}">
                        {{-- @isset($courseSelected)
                            <input type="hidden" name="course_id" value="{{ $courseSelected->id }}">
                        @endisset --}}
                        <button type="submit" class="text-corporate-dark-color fw-bold small text-decoration-underline" style="border: none; background-color: transparent;" type="submit">Filter Sessions</button>
                    </form>
                </div>
            </div>
            
            
        </div>
    @endforeach
</div>

<div class="row">
    <div>                   
        <div class="card my-3">
            <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-calendar-week"></i> Schedule</h6>

                <form method="GET" class="courseActive_id" action="{{route('get.instructor.course.show', $course->id)}}">
                    <input type="hidden" name="coach_id" value="0">
                    {{-- @isset($courseSelected)
                        <input type="hidden" name="course_id" value="{{ $courseSelected->id }}">
                    @endisset --}}
                    <button type="submit" class="text-corporate-dark-color fw-bold small text-decoration-underline" style="border: none; background-color: transparent;" type="submit">Remove Filters</button>
                </form>

            </div>
            <div class="card-body padding-05-rem">
                
                

                @include('admin.course.schedule.section_schedule')

            </div>
        </div>
    </div>
</div>


<style>
    .table-container {
        max-height: 800px; 
        overflow-y: auto; 
    }

    .table thead th {
        position: sticky; 
        top: 0;
        z-index: 1; 
        background-color: #eef7f7; 
        font-weight: bold;
        color: black !important;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#backForm').submit(function(event) {
            event.preventDefault(); 
            var formData = $(this).serialize(); 
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {                  
                    $('.table-container').html(response);
                }
            });
        });

        $('#nextForm').submit(function(event) {
            event.preventDefault(); 
            var formData = $(this).serialize(); 
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    $('.table-container').html(response);
                }
            });
        });

        $('.courseActive_id').submit(function(event) {
            event.preventDefault(); 
            var formData = $(this).serialize(); 
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {                  
                    $('.table-container').html(response);
                }
            });
        });
    });
</script>




