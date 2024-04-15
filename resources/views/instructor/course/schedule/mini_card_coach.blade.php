<div class="row mt-3">
    
        @foreach ($coaches as $coach)
        <div class="col-md-2 d-flex">
            <div class="card h-100" 
                @isset($idCoach)
                    @if ( $coach->id == $idCoach) style="border-color: yellow" @endif
                @endisset>
                
                <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <a href="#" class="mr-2" target="_blank" title="Show coach">
                        {{$coach->name}} {{$coach->lastname}}
                    </a>
                </div>
                <div class="card-body padding-05-rem">
                    <div class="row">
                        <div class="col-3">
                            @if ($coach->url_photo)
                                <img src="{{asset('storage/profile/photo/' . $coach->url_photo)}}" class="img-fluid">
                            @else
                                <i class="fa fa-user fa-3x"></i>
                            @endif   
                        </div>
                        <div class="col-9">

                            <div class="">
                                <p class="mb-0">
                                    <img src="{{ asset('assets/img/flags/' . strtolower($coach->flag) . '.png') }}"
                                        class="img-thumbnail flag-icon-25 me-20" />
                                    {{$coach->countryName}}
                                </p>
                                <p class="mb-0">
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
                                    <i class="fa fa-star small rating-color"></i>
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
                    <form method="GET">
                        <input type="hidden" name="coach_id" value="{{$coach->id}}">
                        @isset($courseSelected)
                            <input type="hidden" name="course_id" value="{{ $courseSelected->id }}">
                        @endisset
                        <button type="submit" class="text-corporate-dark-color fw-bold small text-decoration-underline" style="border: none; background-color: transparent;" type="submit">Filter Sessions</button>
                    </form>
                </div>
            </div>
     
        </div>
        @endforeach
   
</div>