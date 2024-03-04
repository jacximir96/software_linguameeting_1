<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-photo-video me-1"></i>
            Experiences
        </span>

    </div>
    <div class="card-body">
        @include('admin.experience.table_summary', [
            'experiences' => $course->experience,
            'experienceTimezone' => $experienceTimezone
        ])
    </div>
</div>
