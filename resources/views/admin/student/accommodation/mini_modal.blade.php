<div class="container">
    <div class="row ">
        <div class="col-12 border-bottom">
            <span class="bg-corporate-color-light fw-bold">Accommodations</span>
        </div>
        <div class="col-12 mt-3">
            <p>
                <span class="d-inline-block fw-bold me-2">Type:</span>
                <span class="d-inline-block fw-bold text-corporate-dark-color">{{$accommodation->type->description}}</span>
            </p>
            <p>
                <span class="d-inline-block fw-bold me-2">Description:</span>
                @if ($accommodation->hasDescription())
                    {{$accommodation->description}}
                @else
                    -
                @endif
            </p>

            @if ($accommodation->type->hasIndividualSession())
                <p>
                    <span class="d-inline-block fw-bold me-2">Individual Session:</span> Yes
                </p>
            @endif

        </div>
    </div>
</div>
