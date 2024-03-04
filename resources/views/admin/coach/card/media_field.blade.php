<div class="col-md-6">

    <div class="row">
        <div class="col-12">
            <label class="me-3 fw-bold text-corporate-color">Photo</label>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if ($coach->profileImage)

                <div class="row">
                    <div class="col justify-content-start">
                        <a href="{{asset($coach->profileImage->url()->get())}}" target="_blank" title="Show original">
                            <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid" alt="Imagen" style="max-width: 40%">
                        </a>
                    </div>
                </div>

            @else
                <p class="text-muted">
                    Whithout profile image.
                </p>
            @endif
        </div>

    </div>

</div>
<div class="col-md-6">

    <div class="row">
        <div class="col-12">
            <label class="me-3 fw-bold text-corporate-color">Vídeo</label>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if ($coach->coachInfo->url_video)
                <div class="mb-4">
                    <iframe src="{{$coach->coachInfo->url_video}}" frameborder="0" allow="encrypted-media" allowfullscreen id="iframeVideo"></iframe>
                </div>
            @else
                <p class="text-muted">
                    Whithout profile video.
                </p>
            @endif
        </div>

    </div>

</div>
