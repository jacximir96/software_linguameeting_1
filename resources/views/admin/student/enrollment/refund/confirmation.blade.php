<div class="container">
    <div class="row ">
        <div class="col-12 ">
           <p>
               Students are able to refund their LinguaMeeting package anytime <span class="fw-bold">prior to the 24 hours before their first booked session</span>.
           </p>
        </div>
        <div class="col-12 mt-3">
            <p class="text-corporate-danger">
                Please, use this option if you are not going to continue in this course. If you want to change the course or section, use the option "Change Section/Course".
            </p>
        </div>
        <div class="col-12 mt-3 text-end">
            <a href="{{route('get.student.enrollment.refund', $enrollment->id)}}"
                class="btn btn-sm bg-corporate-color text-white">
                Confirm Refund
            </a>
        </div>
    </div>
</div>
