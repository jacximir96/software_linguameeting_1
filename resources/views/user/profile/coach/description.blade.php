<div class="row mt-3">
    <div class="mb-3 col-12 col-xl-6">
        @include('common.form-field.textarea', ['field' => 'description',
                                                'label' => 'Description',
                                                'id' => 'ckeditor',
                                                'rows' => 5,
                                                'data-height' => '200px',
                                                'ckEditor' => 'ckeditor-basic'])


    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="form-group row">
            <div class="col-12 text-600">
                <span class=" mb-2 fw-bold ">Profile image</span>
            </div>
            @if ($form->isEdit())
                @if ($user->profileImage)
                    <div class="col-12 mb-3">
                        <div class="container">
                            <div class="row">
                                <div class="col justify-content-start">
                                    <a href="{{asset($user->profileImage->url()->get())}}" target="_blank" title="Show Original">
                                        <img src="{{asset($user->profileImage->url()->get())}}" class="img-fluid" alt="Image" style="max-width: 40%">
                                    </a>
                                </div>
                                <div class="col-12 mt-2 fw-bold">
                                    <input type="checkbox" name="delete_profile_image" value="1"/> Delete image
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="col-12">
                {{Form::file('profile_image', ['class' => 'profile-image'])}}

                @error('profile_image')
                <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-lg-6">

        <div class="form-group row">
            <div class="col-12 text-600">
                <span class="fw-bold  mb-2  ">Coach Video</span>
            </div>
            @if ($form->isEdit())
                @if ($user->coachInfo->url_video)
                    <div class="mb-4">
                        <iframe src="{{$user->coachInfo->url_video}}" frameborder="0" allow="encrypted-media" allowfullscreen id="iframeVideo"></iframe>
                    </div>
                @endif
            @endif
            <div class="col-12">
                {{Form::url('url_video', null, ['class' => 'form-control '])}}

                @error('url_video')
                <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
</div>

<div class="row mt-3">
    <div class="mb-3 col-12 col-xl-6">
        <div class="form-group row">
            <div class="col-12 text-600">
                <span class=" mb-2 fw-bold ">Hobbies</span>
            </div>
            @foreach ($form->model()['hobbies'] as $hobbyId => $hobbyName)
                <div class="col-12 col-sm-4 mb-2">

                    {{Form::text('hobbies['.$hobbyId.']', null, ['class' => 'form-control form-control-xs'])}}

                </div>
            @endforeach

            @foreach ($form->model()['new_hobbies'] as $hobbyId => $hobbyName)
                <div class="col-12 col-sm-4 mb-2">

                    {{Form::text('new_hobbies['.$hobbyId.']', null, ['class' => 'form-control form-control-xs'])}}

                </div>
            @endforeach
        </div>


    </div>
</div>
