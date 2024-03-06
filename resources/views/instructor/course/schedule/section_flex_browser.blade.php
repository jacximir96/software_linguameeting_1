<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Browser periods in flex course startDate to endDate</h6>
            </div>
            <div class="card-body padding-05-rem">
                <div class="row">
                    <div class="col-6 text-center">
                        <form method="GET" action="{{ route('get.instructor.course.schedule.index') }}">
                            <input type="hidden" name="direction" value="back">
                            @isset($courseSelected)
                                <input type="hidden" name="course_id" value="{{ $courseSelected->id }}">
                            @endisset
                            <button type="submit" class="btn btn-link">
                                <i class="fa fa-arrow-left fa-2x text-muted"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-6 text-center">
                        <form method="GET" action="{{ route('get.instructor.course.schedule.index') }}">
                            <input type="hidden" name="direction" value="next">
                            @isset($courseSelected)
                                <input type="hidden" name="course_id" value="{{ $courseSelected->id }}">
                            @endisset
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
